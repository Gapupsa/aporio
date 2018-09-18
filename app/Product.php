<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;
use App\Unit;
use App\Category;
use App\User;
use App\Supplier;
use Carbon\Carbon;

class Product extends Model
{
    use AutoNumberTrait;

    protected $fillable = ['id',
        'code', 'name', 'user_id','category_id','unit_id','supplier_id',
        'harga_pokok','harga_beli','harga_jual','perInPrice','diskonPer','diskonNom',
        'diskonUnit','minStok','stok','kemasan','komposisi','resepdokter','narkotika',
        'produsen','gambar','isDiskon','expireDate'
    ];

    //protected $dateFormat = 'Y-m-d H:i';

    public function getAutoNumberOptions()
    {
        return [
            'code' => [
                'format' => '?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 8 // The number of digits in an autonumber
            ]
        ];
    }

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

    public function setExpireDateAttribute($value)
    {
        $this->attributes['expireDate'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getExpireDateAttribute($value)
    {
        return $value->setTimezone("Asia/makassar")->format('d-m-Y');
    }

    public function getCreatedAtAttribute($value)
    {
        $date = $this->asDateTime($value);
        return $date->setTimezone("Asia/makassar")->toDateTimeString();
    }

    public function setBatasDiskonAttribute($value)
    {
        $this->attributes['batasDiskon'] = Carbon::parse($value)->format('Y-m-d');
    }
}
