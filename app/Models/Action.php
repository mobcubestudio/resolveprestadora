<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'route',
        'icon',
        'identification',
        'class',
        'on_click',
        'href_disable'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function actionPermission()
    {
        return $this->hasMany(ActionPermission::class);
    }


}
