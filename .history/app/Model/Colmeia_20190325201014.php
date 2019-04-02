<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Colmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'foto', 'descricao', 'apiario_id'
     ];

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at'
    ];
 
     public function apiario ()
     {
        return $this->belongsTo(Apiario::class);
     }

     public function visitaColmeias () {
         return $this->hasMany(Visita::class);
     }

    //  CPF: 104.085.384.-65
    //  Banco: Nu Pagamentos S.A (260)
    //  Agencia: 0001
    //  Conta: 7205241-7

     public function uploadImage($request){

        //$image = "https://bee-check-api.herokuapp.com/storage/images/imgDefault.jpg";
        $image = "http://192.168.200.223/storage/images/imgDefault.jpg";

        if($request->foto ) {
            $name = $request->foto['fileName']; 

            $exists = Storage::disk('public')->has($name);
            if($exists){
                Storage::delete($name);
            }

            Storage::disk('public')->put($name, base64_decode($request->foto['data']));       
            $image = "http://192.168.200.223/storage/images/".$name;
        }

        return $image;
    }

}
