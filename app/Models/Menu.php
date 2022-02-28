<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'asset',
        'class',
        'model',
        'order'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function menuAttach(){
        return $this->belongsToMany(Submenu::class,'menu_attaches','menu_id','submenu_id');
    }

    public function scopeOrderDescending($query)
    {
        return $query->orderBy('order','DESC');
    }

    public function menuPermission()
    {
        return $this->hasMany(MenuPermission::class);
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
