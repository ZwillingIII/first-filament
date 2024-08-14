<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * @property string user_id
 */
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

//    public function comments()
//    {
//        return $this->belongsTo(Review::class);
//    }

    public function comments()
    {
        return $this->hasMany(Review::class);
    }
}
