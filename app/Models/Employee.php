<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
      'name',
        'registration',
      'cpf',
      'rg',
      'address',
      'birth_date',
      'marital_status',
      'email'
    ];

    protected $dates = [
      'deleted_at'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productOutput()
    {
        return $this->hasMany(ProductOutput::class);
    }

    public function productPurchase()
    {
        return $this->hasMany(ProductPurchase::class);
    }


}
