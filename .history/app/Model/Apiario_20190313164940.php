<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apiario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'endereco', 'user_id', 'tecnico_id'
     ];

     protected $dates = [
        'deleted_at',
    ];
 
     public function colmeias ()
     {
        return $this->hasMany(Colmeia::class);
     }

     public function user () {
         return $this->belongsTo(User::class);
     }

     public function temApiario ($id) {
        $apiario = Apiario::
                    ->where('id', $id)
                    ->where('tecnico_id', auth()->user()->id)
                    ->first();
        
        if($apiario != null){
            return $apiario;
        }

        return null;
     }
 
}
