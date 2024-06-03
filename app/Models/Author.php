<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nickname',
        'published_books',
    ];

    // One-to-one relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // One-to-Many relationship with Book model
    public function books()
    {
        return $this->hasMany(Book::class, 'author_id', 'id');
    }
}
