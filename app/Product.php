<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Unit;
use App\Category;
use App\User;
use App\Supplier;

class Product extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
