<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadModel extends Model
{
    protected $table = 'leads';

    protected $fillable = [
        'name',
        'client_name',
        'contact',
        'value',
        'currency',
        'description',
        'created_by',
        'assigned_to',
        'start_date',
        'end_date',
        'status',
    ];

/*
    Relationship
*/

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
