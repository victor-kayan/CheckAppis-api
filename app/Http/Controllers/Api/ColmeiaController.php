<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Colmeia;
use Illuminate\Http\Request;
use App\Model\VisitaColmeia;

class ColmeiaController extends Controller
{
    private $colmeia;

    public function __construct(Colmeia $colmeia)
    {
        $this->colmeia = $colmeia;
        $this->middleware('role:apicultor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $images = [];
        $files = \Illuminate\Support\Facades\Storage::disk('s3')->files('images');
        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace('images/', '', $file),
                'src' => $url . $file,
            ];
        }

        return $images;
    }

    public function colmeiasApiario($id)
    {
        // return $id;
        $colmeias = Colmeia::where('apiario_id', $id)->get();

        return response()->json([
            'message' => 'Lista de colmeias do apiario ' . $id,
            'colmeias' => $colmeias,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string',
            'apiario_id' => 'required|exists:apiarios,id',
        ]);

        $this->colmeia = $this->colmeia::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'apiario_id' => $request->apiario_id,
        ]);

        $this->colmeia->foto = $this->colmeia->uploadImage($request);

        $this->colmeia->save();

        return response()->json([
            'message' => 'Colmeia salva com sucesso',
            'colmeia' => $this->colmeia,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->colmeia = $this->colmeia->findOrFail($id);

        return response()->json([
            'message' => 'Detalhes da colmeia',
            'colmeia' => $this->colmeia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->colmeia = $this->colmeia->findOrFail($id);

        $this->colmeia->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'apiario_id' => $request->apiario_id,
        ]);
        if ($request->foto != null) {
            $this->colmeia->foto = $this->colmeia->uploadImage($request);
            $this->colmeia->save();
        }

        return response()->json([
            'message' => 'Colmeia salva com sucesso',
            'colmeia' => $this->colmeia,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->colmeia = $this->colmeia->findOrFail($id);
        $this->colmeia->visitaColmeias()->delete();
        $deleted = $this->colmeia->delete();
    

        if ($deleted) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'error' => 'Recurso não pode ser excluido',
            ], 500);
        }
    }
}
