<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitaApiario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'temAgua', 'temSobra', 'temComida', 'data_visita'
     ];

     protected $hidden = [
        'deleted_at', 'updated_at', 'created_at', 'updated_at'
     ];

     protected $dates = [
        'deleted_at',
     ];

     public function visitaColmeias () {
         return $this->hasMany(VisitaColmeia::class);
     }
}
