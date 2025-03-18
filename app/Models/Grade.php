<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'score'];

    // Relationship: Grade belongs to a Student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship: Grade belongs to a Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
