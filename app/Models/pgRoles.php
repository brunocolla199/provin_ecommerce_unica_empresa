<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pgRoles extends Model 
{
    public $table = 'pg_roles';

    protected $fillable = [
        'rolname'
    ];
}