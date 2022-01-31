<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patrimony extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'serial_no',
        'comment'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
