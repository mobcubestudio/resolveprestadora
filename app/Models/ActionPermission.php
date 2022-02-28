<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionPermission extends Model
{
    use HasFactory;


    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function submenu()
    {
        return $this->belongsTo(Submenu::class);
    }
    public function action()
    {
        return $this->belongsTo(Action::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
