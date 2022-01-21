<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOutput extends Model
{
    use HasFactory;

    protected $fillable = [
      'amount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function output()
    {
        return $this->belongsTo(Output::class);
    }
}
