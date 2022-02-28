<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'asset'
    ];

    protected $dates = [
        'deleted_at'
    ];



    public function scopeOrderDescending($query)
    {
        return $query->orderBy('order','DESC');
    }

    public function submenuPermission()
    {
        return $this->hasMany(SubmenuPermission::class);
    }

    public function actionPermission()
    {
        return $this->hasMany(ActionPermission::class);
    }
}
