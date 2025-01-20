<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        "flight_id",
        "code"
    ];

    public function flight() : BelongsTo {
        return $this->belongsTo(Ticket::class, 'flight_id', 'id');
    }
}
