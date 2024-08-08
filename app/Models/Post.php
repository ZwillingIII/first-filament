<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'created_at',
        'updated_at',
        'user_id',
        'active',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
