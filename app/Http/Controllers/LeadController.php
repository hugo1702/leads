<?php

namespace App\Http\Controllers;

use App\Models\LeadModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function index()
    {
        $leads = LeadModel::with(['createdBy', 'assignedTo'])->get();
        return view('admin.leads.index', compact('leads'));
    }


    public function create()
    {
        $users = User::where('active', 1)
            ->where('role', 'operador')
            ->get();
        return view('admin.leads.create', compact('users'));
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
        ]);

        if ($request->assignment_type === 'auto') {
            $assignedUser = User::where('role', 'operador')
                ->where('participate_assignment', 1)
                ->where('active', 1)
                ->leftJoin('leads', 'users.id', '=', 'leads.assigned_to')
                ->select('users.id', DB::raw('COUNT(leads.id) as leads_count'))
                ->groupBy('users.id')
                ->orderBy('leads_count', 'asc')
                ->first();

            $assignedTo = $assignedUser?->id;
        } else {
            $assignedTo = $request->input('assigned_to');
        }

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

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }
}
