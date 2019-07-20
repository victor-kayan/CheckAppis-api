<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = [
        'uf',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at'
    ];

    public function cidades() {
        return $this->hasMany(Cidade::class);
    }
}
