<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visita extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao'
     ];

     protected $dates = [
        'deleted_at',
    ];
}
