<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relationship: User belongs to a role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relationship: User (Teacher) teaches Subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    // Relationship: User (Student) has many Grades
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }
}

