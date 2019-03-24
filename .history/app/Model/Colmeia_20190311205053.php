<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Apiario;

class Colmeia extends Model
{
    protected $fillable = [
        'nome', 'foto'
     ];
 
     public function apiario()
     {
         return $this->belongsTo(Apiario::class);
     }
 
}
