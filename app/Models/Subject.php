<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'teacher_id'];

    // Relationship: Subject belongs to a Teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relationship: Subject has many Grades
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
