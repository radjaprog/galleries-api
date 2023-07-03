<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    const PER_PAGE = 10;

    protected $table = 'galleries';

    protected $fillable = [
        'name',
        'content',
        'user_id'
    ];

    protected $with = [
        'images'
    ];

    public function scopeUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
