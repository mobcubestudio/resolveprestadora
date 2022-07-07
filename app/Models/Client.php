<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Client extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cnpj',
        'name',
        'address',
        'number',
        'district'
    ];

    protected $dates = [
      'deleted_at'
    ];

    public function output()
    {
        return $this->hasMany(Output::class);
    }

    public function patrimony(){
        return $this->hasMany(Patrimony::class);
    }




}
