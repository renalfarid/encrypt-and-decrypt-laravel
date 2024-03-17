<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeUserLogin() {
        $query = "SELECT email, password FROM users WHERE email = ?";
        return $query;
    }

    public function scopeAddUser() {
        $query = "INSERT INTO users (name, email, password, salt) VALUES (? , ?, ?, ?)";
        return $query;
    }

    public function scopeUserById($query, $id){
        return $query->where('id', $id);
    }

    public function scopeGetSalt() {
        $query = "SELECT salt from users WHERE id = ?";
        return $query;
    }

    public function scopeGetLastUser() {
        $query = "SELECT name, email FROM users ORDER BY id DESC LIMIT 1";
        return $query;
    }


}
