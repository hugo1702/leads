<?php

namespace App\Http\Controllers;

use App\Models\LeadModel;
use Illuminate\Http\Request;

class OperatorLeadController extends Controller
{
    public function index(Request $request)
    {
        $query = LeadModel::with(['assignedTo', 'createdBy'])
            ->where('assigned_to', auth()->id());
        $status = $request->filled('status') ? $request->status : 'abierto';

        $query->where('status', $status);

        $leads = $query->orderBy('created_at', 'desc')->get();

        return view('operator.leads.index', compact('leads'));
    }

    public function changestatus($id)
    {
        $lead = LeadModel::findOrFail($id);

        switch ($lead->status) {
            case 'abierto':
                $lead->status = 'cerrado';
                $lead->end_date = now();
                break;
            case 'cerrado':
            default:
                $lead->status = 'abierto';
                break;
        }

        $lead->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
}
