<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cnpj',
        'name',
        'address'
    ];

    protected $dates = [
      'deleted_at'
    ];

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
