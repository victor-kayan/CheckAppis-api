<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'foto', 'descricao', 'apiario_id'
     ];

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at'
    ];
 
     public function apiario ()
     {
        return $this->belongsTo(Apiario::class);
     }

     public function visitaColmeias () {
         return $this->hasMany(Visita::class);
     }

}
