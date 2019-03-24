<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Colmeia;
use App\Model\Intervencao;

class IntervencaoColmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao', 'data_inicio', 'data_fim' ,'colmeia_id', 'intervencao_id', 'is_concluido'
     ];

     protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at', 'colmeia_id', 'intervencao_id', 'is_concluido'
    ];

    public function colmeia () {
        return $this->belongsTo(Colmeia::class);
    }

    public function intervencao(){
        return $this->belongsTo(Intervencao::class);
    }
}
