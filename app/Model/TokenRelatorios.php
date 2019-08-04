<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TokenRelatorios extends Model
{
    protected $fillable = [
        'token_relatorios',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at',
    ];

    public function cidades()
    {
        return $this->hasMany(Cidade::class);
    }
}
