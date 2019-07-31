<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apiario extends Model
{
    use SoftDeletes;

    protected $fillable = [
          'nome', 'descricao', 'endereco_id', 'apicultor_id', 'tecnico_id', 'latitude', 'longitude',
     ];

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function colmeias()
    {
        return $this->hasMany(Colmeia::class);
    }

    public function apicultor()
    {
        return $this->belongsTo(User::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function visitaApiarios()
    {
        return $this->hasMany(VisitaApiario::class);
    }

    public function findApiario($id)
    {
        $apiario = Apiario::where('id', $id)->where('tecnico_id', auth()->user()->id)->first();
        if ($apiario != null) {
            return $apiario;
        }
        abort(404, 'Apiário não encontrado.');
        // return $apiario ? $apiario : abort(422, 'Apiáio não encontrado');
    }
}
