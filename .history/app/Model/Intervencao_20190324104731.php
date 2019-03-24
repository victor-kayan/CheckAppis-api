<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intervencao extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao', 'apiario_id',
     ];

     protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at'
    ];

    public function apiario(){
        return $this->belongsTo(Apiario::class);
     }
}
