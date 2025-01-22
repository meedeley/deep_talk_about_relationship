<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = [
        "name",
        "exp"
    ];

    public function hobbies() : BelongsToMany
    {
        return $this->belongsToMany(Hobby::class, 'student_hobby')->as('student_hobby')->withPivot('sub_exp')->withTimestamps();
    }
}
