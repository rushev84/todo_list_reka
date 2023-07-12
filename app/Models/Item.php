<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'name', 'description',
        'completed',
        'due_date',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function list()
    {
        return $this->belongsTo(TodoList::class);
    }
}
