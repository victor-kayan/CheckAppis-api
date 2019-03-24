<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Colmeia;

class IntervencaoColmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao', 'colmeia_id', 'intervencao_id',
     ];

     protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at'
    ];

    public function colmeia () {
        return $this->belongsTo(Colmeia::class);
    }
}
