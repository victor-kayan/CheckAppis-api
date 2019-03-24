<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitaColmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao', 'id', 'temComida' , 'temSombra' , 'temAgua' , 'temAbelhasMortas' , 'qtdQuadrosMel' , 'qtdQuadrosPolen',
            'qtdCriaAberta' , 'qtdCriaFechada' , 'data_visita', 'colmeia_id'
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