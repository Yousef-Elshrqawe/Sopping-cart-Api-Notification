<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['start_date', 'expire_date'];

    public function type()
    {
        return $this->amount_type == '0' ? '$' : '%';
    }

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }


    public function scopeCheckOffer()
    {
        if (!$this->checkDate() || !$this->checkUsedTimes()){
            return 0;
        }
    }

    protected function checkDate()
    {
        return $this->expire_date != '' ? (Carbon::now()->between($this->start_date, $this->expire_date, true)) ? true : false : true;
    }

    protected function checkUsedTimes()
    {
        return $this->use_times != '' ? ( $this->use_times > $this->used_times ) ? true : false : true;
    }

    protected function checkGreaterThan($total)
    {
        return $this->greater_than != '' ? ($this->greater_than >= $total) ? true : false : true;
    }

    public  function products()
    {
        return $this->belongsToMany(Product::class, 'product_offers');
    }

    public function  users(){
        return $this->belongsToMany(User::class, 'user_offers');
    }




}
