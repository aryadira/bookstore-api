<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'price', 'author', 'description', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rent()
    {
        return $this->belongsTo(Rent::class, 'book_id', 'id');
    }

    public function rent_return()
    {
        return $this->belongsTo(RentReturn::class, 'book_Id', 'id');
    }
}
