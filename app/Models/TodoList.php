<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = [
        'user_id', 'name',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
