<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seller extends Model
{
    protected $table = "sellers";

    protected $fillable = [
        "name"
    ];

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'seller_id', 'id');
    }
}
