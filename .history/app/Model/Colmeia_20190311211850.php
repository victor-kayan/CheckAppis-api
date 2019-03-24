<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Apiario;

class Colmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'foto', 'deescricao'
     ];

    protected $dates = [
        'deleted_at',
    ];
 
     public function apiario ()
     {
        return $this->belongsTo(Apiario::class);
     }
 
}
