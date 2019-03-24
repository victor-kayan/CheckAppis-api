<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Colmeia;

class Apiario extends Model
{
    protected $fillable = [
        'descricao'
     ];
 adasdas
     public function colmeias ()
     {
        return $this->hasMany(Colmeia::class);
     }
 
}
