<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $fillable = [
        'ordered_by',
        'ordered_date_time',
        'selected_by',
        'selected_date_time',
        'sent_by',
        'sent_date_time',
        'status'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function productOutput(){
        return $this->hasMany(ProductOutput::class);
    }
}
