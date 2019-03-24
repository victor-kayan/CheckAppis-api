<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitaColmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao', 'id' , 'tem_abelhas_mortas' , 'qtd_quadros_mel' , 'qtd_quadros_polen',
            'qtd_cria_aberta' , 'qtd_cria_fechada' , 'data_visita', 'colmeia_id', 'observacao', 'tem_postura'
     ];

     protected $hidden = [
        'deleted_at', 'updated_at', 'created_at', 'updated_at'
     ];

     protected $dates = [
        'deleted_at',
     ];

     public function colmeia () {
         return $this->belongsTo(Colmeia::class);
     }

     public function visitaApiario () {
         return $this->belongsTo(VisitaApiario::class);
     }
     
}