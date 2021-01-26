<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Role;
use App\Models\Wish_list;
use App\Models\Application;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    
    public function wishList()
    {
        return $this->hasOne(Wish_list::class);
    }
}
