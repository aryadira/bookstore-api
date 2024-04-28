<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role'
    ];

    public function book()
    {
        return $this->hasMany(Book::class, 'user_id', 'id');
    }

    public function rent()
    {
        return $this->hasMany(Rent::class, 'user_id', 'id');
    }

    public function rent_return()
    {
        return $this->hasMany(RentReturn::class, 'user_id', 'id');
    }
}
