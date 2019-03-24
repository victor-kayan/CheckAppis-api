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

     public function uploadImage($request, $colmeia){

        if($request->foto) {
            $name = $request->foto['fileName']; 
            Storage::disk('public')->put($name, base64_decode($request->foto['data']));
          
            $colmeia->foto = "http://192.168.200.253/storage/colmeias/".$name;
        }else {
            $colmeia->foto = "http://192.168.200.253/storage/colmeias/imgDefault.jpj";
        }

        $colmeia->save();
        
        return response()->json([
            'message' => 'Colmeia salva com sucesso',
            'colmeia' => $colmeia
        ], 200);
    }

}
