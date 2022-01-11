<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOutput extends Model
{
    use HasFactory;

    protected $fillable = [
      'date_time_order',
      'date_time_selected',
      'date_time_sent',
      'amount',
      'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
