<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hobby extends Model
{
    protected $fillable = [
        "name"
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_hobby')->as('student_hobby')->withPivot('sub_exp')->withTimestamps();
    }
}
