<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'roster_id',
        'name', 'description',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function roster()
    {
        return $this->belongsTo(Roster::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
