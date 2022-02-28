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
        'role_id',
      'name',
        'registration',
      'cpf',
      'rg',
      'address',
      'birth_date',
      'marital_status',
      'email',
        'phone'
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
        return $this->hasOne(User::class,'employee_id','id');
    }

    public function productOutput()
    {
        return $this->hasMany(ProductOutput::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }


}
