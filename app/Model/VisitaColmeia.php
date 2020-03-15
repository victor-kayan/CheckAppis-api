<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitaColmeia extends Model
{

    protected $fillable = [
        'descricao', 'id', 'tem_abelhas_mortas', 'qtd_quadros_mel', 
            'qtd_quadros_polen', 'visita_apiario_id', 'qtd_cria_aberta', 
            'qtd_cria_fechada', 'qtd_quadros_vazios', 'colmeia_id', 
            'observacao', 'tem_postura', 'tem_zangao', 'tem_realeira'
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function colmeia()
    {
        return $this->belongsTo(Colmeia::class);
    }

    public function visitaApiario()
    {
        return $this->belongsTo(VisitaApiario::class);
    }

}
