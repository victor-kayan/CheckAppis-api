<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

     public function upload($request, $colmeia){
        $colmeia = Colmeia::findOrFail($colmeia->id);
        
        if($request->foto && $request->foto != $colmeia->foto){
            $image_parts = explode(";base64,", $request->foto);
            $image_type_aux = explode("image/", $image_parts[0]);
            $name = uniqid(date('HisYmd').$request->foto->filename);
            $nameFile = "{$colmeia->id}.{$image_type_aux[1]}";
            $exists = Storage::disk('public')->has($nameFile);
            if($exists){
                Storage::delete($nameFile);
            }
            Storage::disk('public')->put($nameFile, base64_decode($image_parts[1]));
            $colmeia->foto = Constantes::BASE_URL."/storage/colmeias/".$nameFile;
        }
        $colmeia->name = $request->name;
        $colmeia->email = $request->email;
        $colmeia->save();
        Cache::flush(); //resetando o cache para atualizar os dados dos usuarios nos incidentes e nos historicos
        return response()->json([
            'message' => 'Atualizado com sucesso',
            'colmeia' => $colmeia
        ], 200);
    }

}
