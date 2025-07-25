<?php

namespace App\Http\Controllers;

use App\Models\LeadModel;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = LeadModel::with(['assignedTo', 'createdBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leads = $query->orderBy('created_at', 'desc')->get();

        return view('admin.leads.index', compact('leads'));
    }


    public function create()
    {
        $users = User::where('active', 1)
            ->where('role', 'operador')
            ->get();
        return view('admin.leads.create', compact('users'));
    }

    private function getAutomaticAssignedUserId()
    {
        $assignedUser = User::where('role', 'operador')
            ->where('participate_assignment', 1)
            ->where('active', 1)
            ->withCount('leads')
            ->orderBy('leads_count', 'asc')
            ->first();

        return $assignedUser?->id;
    }


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
            'status' => 'Abierto',
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead creado correctamente.');
    }


    public function edit($id)
    {
        $lead = LeadModel::findOrFail($id);
        $users = User::all();

        return view('admin.leads.edit', compact('lead', 'users'));
    }

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

    public function destroy($id)
    {
        $lead = LeadModel::findOrFail($id);
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead eliminado correctamente.');
    }



    public function exportpdf(Request $request)
    {
        // Obtener todos los usuarios con rol "operador"
        $operadores = User::where('role', 'operador')->get();

        // Preparar una colección con estadísticas por operador
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

        $date = now();

        // Cargar PDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.reports.report_pdf', [
            'operadoresConStats' => $operadoresConStats
        ])->setPaper('legal', 'portrait');

        return $pdf->download('reporte_leads' . now()->format('Ymd_H:i:s') . '.pdf' );
    }
}
