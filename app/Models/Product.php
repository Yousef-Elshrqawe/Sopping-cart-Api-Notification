<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'quantity',
        'status',

    ];

    public function  scopeInactive($query)
    {
        return $query->where('status', 0);
    }
}
