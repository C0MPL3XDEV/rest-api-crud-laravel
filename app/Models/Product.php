<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name', 'description', 'price', 'created_at',
         'date', 'client_name', 'client_image',
        'deadline_date', 'status',
    ];
}
