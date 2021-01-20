<?php

namespace App\Models;

use App\Models\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Historical_price extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['price', 'application_id', 'created_at'];

    public function applications()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
