<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Historical_price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;
        
    protected $fillable = ['name', 'price', 'image_src', 'category_id', 'user_id'];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function historical_prices()
    {
        return $this->hasMany(Historical_price::class);
    }

}
