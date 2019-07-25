<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Colmeia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'foto', 'descricao', 'apiario_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'created_at',
    ];

    public function apiario()
    {
        return $this->belongsTo(Apiario::class);
    }

    public function intervencaoColmeias()
    {
        return $this->hasMany(IntervencaoColmeia::class);
    }

    public function visitaColmeias()
    {
        return $this->hasMany(VisitaColmeia::class);
    }

    public function uploadImage($request)
    {

        $baseURLImage = "https://s3-sa-east-1.amazonaws.com/beecheck/images/";

        if ($request->foto) {
            $name = $request->foto['fileName'];

            $exists = Storage::disk('s3')->has($name);
            if ($exists) {
                Storage::delete($name);
            }
            Storage::disk('s3')->put("images/" . $name, base64_decode($request->foto['data']));
            $image = $baseURLImage . $name;
        } else {
            $image = $baseURLImage . "default.png";
        }

        return $image;
    }

}
