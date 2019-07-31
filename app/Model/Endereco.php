<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'logradouro', 'cidade_id',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at',
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }
}
