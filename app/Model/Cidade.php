<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = [
        'nome', 'uf'
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function estado() {
        return $this->belongsTo(Estado::class);
    }
}
