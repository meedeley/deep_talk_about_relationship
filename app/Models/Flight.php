<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flight extends Model
{
    protected $fillabel = [
        "name"
    ];

    public function tickets() : HasMany 
    {
        return $this->hasMany(Ticket::class, 'flight_id', 'id');
    }
}
