<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Apiario;

class Intervencao extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao', 'data_inicio', 'data_fim' , 'apiario_id', 'tecnico_id'
     ];

     protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'apiario_id', 'tecnico_id'
    ];

    public function apiario(){
        return $this->belongsTo(Apiario::class);
    }

     public function user () {
        return $this->belongsTo(User::class);
    }
}
