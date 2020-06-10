<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitaApiario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tem_agua', 'tem_sombra', 'tem_comida', 'apiario_id', 'observacao',
        'qtd_quadros_mel', 'qtd_quadros_polen', 'qtd_cria_aberta', 'qtd_cria_fechada', 'qtd_quadros_vazios',
        'qtd_colmeias_com_postura', 'qtd_colmeias_com_abelhas_mortas', 'qtd_colmeias_com_zangao', 'qtd_colmeias_com_realeira',
        'qtd_colmeias_sem_postura', 'qtd_colmeias_sem_abelhas_mortas', 'qtd_colmeias_sem_zangao', 'qtd_colmeias_sem_realeira',
        'qtd_quadros_analizados'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'updated_at',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function visitaColmeias()
    {
        return $this->hasMany(VisitaColmeia::class);
    }

    public function apiario()
    {
        return $this->belongsTo(Apiario::class);
    }
}
