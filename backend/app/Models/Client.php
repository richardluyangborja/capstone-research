<?php

namespace App\Models;

use App\Enums\ClientStatus;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'company_id',
        'assigned_to_id',
        'status',
        'client_since',
        'notes',
    ];

    protected $casts = [
        'status' => ClientStatus::class,
        'client_since' => 'date',
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
