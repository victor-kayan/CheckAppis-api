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

      //  $colmeia = Colmeia::findOrFail($colmeia->id);

        
        //$image_parts = explode(";base64,", $request->foto);
        //$image_type_aux = explode("image/", $image_parts[0]);
        $name = uniqid($request->foto['fileName']);

       return $name;
        // $nameFile = "{$colmeia->id}.{$image_type_aux[1]}";
        // $exists = Storage::disk('public')->has($nameFile);
        // if($exists){
        //     Storage::delete($nameFile);
        // }
        Storage::disk('public')->put($name, base64_decode($request->foto['data']));
        $colmeia->foto = "http://192.168.200.253/storage/colmeias/".$name;
        //$colmeia->name = $request->name;
       // $colmeia->foto = $request->email;
       //return $colmeia;

        $colmeia->save();
       // Cache::flush(); //resetando o cache para atualizar os dados dos usuarios nos incidentes e nos historicos
        return response()->json([
            'message' => 'Atualizado com sucesso',
            'colmeia' => $colmeia
        ], 200);
    }

}
