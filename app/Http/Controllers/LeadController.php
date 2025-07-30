<?php

namespace App\Http\Controllers;

use App\Models\LeadModel;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * Controlador para gestionar los leads desde el panel de administración.
 */
class LeadController extends Controller
{
    /*Muestra una lista de leads con posibilidad de filtrar por estado.
    Carga relaciones con los usuarios asignados (`assignedTo`) y quienes los crearon (`createdBy`).
    Ordena los resultados por fecha de creación descendente.
    */
    public function index(Request $request)
    {
        $query = LeadModel::with(['assignedTo', 'createdBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(8);

        return view('admin.leads.index', compact('leads'));
    }


    /*
    Muestra el formulario para crear un nuevo lead.

    Obtiene todos los usuarios activos con el rol de operador
    para asignarlos en la creación del lead.*/
    public function create()
    {
        $users = User::where('active', 1)
            ->where('role', 'operador')
            ->withCount(['leads' => function ($query) {
                $query->where('status', 'abierto');
            }])
            ->orderBy('leads_count', 'asc')
            ->get();
        return view('admin.leads.create', compact('users'));
    }


    /* Obtiene el ID del operador al que se le debe asignar automáticamente un lead.
    Busca entre los usuarios con rol 'operador' que estén activos y participen
    en asignaciones automáticas, ordenados por la menor cantidad de leads asignados.
    */
    private function getAutomaticAssignedUserId()
    {
        $assignedUser = User::where('role', 'operador')
            ->where('participate_assignment', 1)
            ->where('active', 1)
            ->withCount([
                'leads as open_leads_count' => function ($query) {
                    $query->where('status', 'abierto');
                }
            ])
            ->orderBy('open_leads_count', 'asc')
            ->first();

        return $assignedUser?->id;
    }



    /* Almacena un nuevo lead en la base de datos.

    Valida los datos del formulario, asigna el lead a un operador de forma manual o automática,
    y crea el registro con estado inicial "abierto".
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'value' => 'nullable|numeric',
            'currency' => 'required|string|size:3',
            'description' => 'nullable|string',
            'assignment_type' => 'required|in:auto,manual',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $assignedTo = $request->assignment_type === 'manual'
            ? $request->input('assigned_to')
            : $this->getAutomaticAssignedUserId();

        LeadModel::create([
            'name' => $request->name,
            'client_name' => $request->client_name,
            'contact' => $request->contact,
            'value' => $request->value,
            'currency' => $request->currency,
            'description' => $request->description,
            'created_by' => auth()->id(),
            'assigned_to' => $assignedTo,
            'start_date' => now(),
            'end_date' => null,
            'status' => 'abierto',
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead creado correctamente.');
    }


    /* Muestra el formulario para editar un lead específico.

    Busca el lead por su ID y obtiene todos los usuarios para poder reasignar si es necesario.
    */
    public function edit($id)
    {
        $lead = LeadModel::findOrFail($id);
        $users = User::all();

        return view('admin.leads.edit', compact('lead', 'users'));
    }

    /* Actualiza los datos de un lead existente.

    Valida la información recibida, busca el lead por su ID y actualiza sus campos.
    La asignación puede ser manual o automática según el tipo seleccionado. */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'value' => 'nullable|numeric',
            'currency' => 'required|string|size:3',
            'description' => 'nullable|string',
            'assignment_type' => 'required|in:auto,manual',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $lead = LeadModel::findOrFail($id);

        $lead->name = $request->name;
        $lead->client_name = $request->client_name;
        $lead->contact = $request->contact;
        $lead->value = $request->value;
        $lead->currency = $request->currency;
        $lead->description = $request->description;

        $lead->assigned_to = $request->assignment_type === 'manual'
            ? $request->assigned_to
            : $this->getAutomaticAssignedUserId();

        $lead->save();

        return redirect()->route('admin.leads.index')->with('success', 'Lead actualizado correctamente.');
    }

    /* Elimina un lead específico de la base de datos.

    Busca el lead por su ID y lo elimina. Luego redirige a la lista con mensaje de éxito.
    */
    public function destroy($id)
    {
        $lead = LeadModel::findOrFail($id);
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead eliminado correctamente.');
    }


    /* Genera y descarga un reporte PDF con estadísticas de leads por operador. */
    public function exportpdf()
    {
        $operadores = User::where('role', 'operador')->get();

        $operadoresConStats = $operadores->map(function ($operador) {
            $leads = LeadModel::where('assigned_to', $operador->id)->get();

            return [
                'nombre' => $operador->name,
                'correo' => $operador->email,
                'total' => $leads->count(),
                'abiertos' => $leads->where('status', 'abierto')->count(),
                'cerrados' => $leads->where('status', 'cerrado')->count(),
            ];
        });

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.reports.report_pdf', [
            'operadoresConStats' => $operadoresConStats
        ])->setPaper('legal', 'portrait');

        return $pdf->download('reporte_leads' . now()->format('Ymd_H:i:s') . '.pdf');
    }


    /*Prepara y muestra la vista con la gráfica de leads por operador.
    Obtiene todos los usuarios con rol "operador" y calcula la cantidad de leads abiertos y cerrados asignados a cada uno.

    También suma el total de leads abiertos y cerrados para todos los operadores.
    */
    public function vistaGraficaLeads()
    {
        $operadores = User::where('role', 'operador')->get();

        $operadoresConStats = $operadores->map(function ($operador) {
            $leads = LeadModel::where('assigned_to', $operador->id)->get();

            return [
                'nombre' => $operador->name,
                'abiertos' => $leads->where('status', 'abierto')->count(),
                'cerrados' => $leads->where('status', 'cerrado')->count(),
            ];
        });

        $totalAbiertos = $operadoresConStats->sum('abiertos');
        $totalCerrados = $operadoresConStats->sum('cerrados');

        return view('admin.reports.grap', compact('operadoresConStats', 'totalAbiertos', 'totalCerrados'));
    }
}
