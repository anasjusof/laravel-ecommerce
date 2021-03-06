<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function presentPrice(){
        return '$ ' . $this->price;
    }

    public function scopeMightAlsoLike($query){
        return $query->inRandomOrder()->take(4);
    }
}
