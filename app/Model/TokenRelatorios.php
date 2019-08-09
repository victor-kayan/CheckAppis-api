<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TokenRelatorios extends Model
{
    protected $fillable = [
        'token_relatorios', 'tecnico_id',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at',
    ];
}
