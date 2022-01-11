<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'amount',
        'amount_alert'
    ];

    protected $dates = [
      'deleted_at'
    ];

    public function productPurchase()
    {
        return $this->hasMany(ProductPurchase::class);
    }

    public function productOutput()
    {
        return $this->hasMany(ProductOutput::class);
    }
}
