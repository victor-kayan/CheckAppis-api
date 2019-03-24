<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'foto', 'deescricao', 'latitude', 'longitude'
     ];

    protected $dates = [
        'deleted_at',
    ];
 
     public function apiario ()
     {
        return $this->belongsTo(Apiario::class);
     }

}
