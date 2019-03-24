<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'foto', 'descricao', 'latitude', 'longitude', 'apiario_id'
     ];

    protected $dates = [
        'deleted_at',
    ];
 
     public function apiario ()
     {
        return $this->belongsTo(Apiario::class);
     }

}
