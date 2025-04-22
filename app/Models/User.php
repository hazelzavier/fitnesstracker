<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    /**
     * Relationship with the Clothing model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clothing()
    {
        return $this->hasMany(Clothing::class);
    }

    public function clothes()
    {
        return $this->belongsToMany(Clothing::class, 'user_clothing'); // Pivot table: 'user_clothing'
    }
    
    /**
     * Relationship with the Outfit model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outfits()
    {
        return $this->hasMany(Outfit::class);
    }
}
