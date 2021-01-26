<?php

namespace App\Models;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function applications(){
        return $this->morphToMany(Application::class, 'applicationable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
