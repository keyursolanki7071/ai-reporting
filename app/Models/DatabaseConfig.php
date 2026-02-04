<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseConfig extends Model
{
    protected $fillable = [
        'host',
        'port',
        'database',
        'username',
        'password',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'encrypted',
    ];
}
