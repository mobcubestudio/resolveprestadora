<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuAttach extends Model
{
    use HasFactory;

    protected $fillable = [
      'order'
    ];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
    public function submenu(){
        return $this->belongsTo(Submenu::class);
    }
    public function submenuAttach(){
        return $this->belongsToMany(Action::class,'submenu_attaches','menu_attach_id','action_id');
    }
}
