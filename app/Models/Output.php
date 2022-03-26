<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Output extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ordered_by',
        'selected_by',
        'sent_by',
        'received_by',
        'received_notes',
        'status',
        'is_epi',
        'epi_employee_id'

    ];

    protected $dates = [
        'ordered_date_time',
        'selected_date_time',
        'sent_date_time',
        'received_date_time',
        'deleted_at'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function productOutput(){
        return $this->hasMany(ProductOutput::class);
    }

    public function getStatusAttribute(){
        $statusName = ['P'=>'Solicitado','S'=>'Separado','E'=>'Entregue','R'=>'Rota de Entrega'];
        return $statusName[$this->attributes['status']];
    }

    public function getIsEpiImgAttribute(){
        $funcionario = ($this->attributes['is_epi'] == 1) ? Employee::where('id','=',$this->attributes['epi_employee_id'])->first()->name : '';
        $epiStatus = [0=>'',1=>'<img title="' . $funcionario . '" src="' . asset('images/epi.png') . '" />'];
        return $epiStatus[$this->attributes['is_epi']];
    }

}
