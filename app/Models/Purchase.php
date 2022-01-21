<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'price'
    ];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function productPurchase(){
        return $this->hasMany(ProductPurchase::class);
    }
}
