<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'company_id',
        'assigned_to_id',
        'source',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => LeadStatus::class,
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }
}
