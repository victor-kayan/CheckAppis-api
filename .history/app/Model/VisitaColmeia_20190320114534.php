<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitaColmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao', 'id' , 'temAbelhas_mortas' , 'qtd_quadros_mel' , 'qtd_quadros_polen',
            'qtdCriaAberta' , 'qtd_cria_fechada' , 'data_visita', 'colmeia_id'
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