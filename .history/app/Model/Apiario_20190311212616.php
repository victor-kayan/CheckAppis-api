<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apiario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao'
     ];

     protected $dates = [
        'deleted_at',
    ];

 
     public function colmeias ()
     {
        return $this->hasMany(Colmeia::class);
     }
 
}
