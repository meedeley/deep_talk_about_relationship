<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentHobby extends Pivot
{
    protected $fillable = [
        "student_id",
        "hobby_id",
        "sub_exp",
    ];
}
