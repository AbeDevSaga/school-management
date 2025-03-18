<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    use HasFactory;

    protected $fillable = ['role_id', 'permission_id'];

    public $timestamps = false;
}

