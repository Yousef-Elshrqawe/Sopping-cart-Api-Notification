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

    public function  scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function subTotal($total)
    {
        return $this->amount_type == '0' ? $this->amount   : (($total * $this->amount) / 100) ;

    }
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'product_offers');
    }

    public function  users(){
        return $this->belongsToMany(User::class, 'user_offers');
    }
}
