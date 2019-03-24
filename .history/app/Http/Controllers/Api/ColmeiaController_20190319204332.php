<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Colmeia;
use App\Model\User;
use App\Model\Apiario;

class ColmeiaController extends Controller
{
    private $colmeia;

    public function __construct(Colmeia $colmeia){
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
       
    }

    public function colmeiasApiario($id){
        // return $id;
        $colmeias = Colmeia::where('apiario_id', $id)->get();

        return response()->json([
            'message' => 'Lista de colmeias do apiario '.$id,
            'colmeias' => $colmeias
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
        //return $request->foto['fileName'];
        // $nameFile = null;

        $request->validate([
            'nome'        => 'required|string',
            'descricao'   => 'required|string',
            'apiario_id'  => 'required|exists:apiarios,id',
         ]);
 
        // // Verifica se informou o arquivo e se é válido
        // if ($request->hasFile('foto') && $request->file('foto')->isValid()) {

        //     return 'Aquiiiii';
            
        //     // Define um aleatório para o arquivo baseado no timestamps atual
        //     $name = uniqid(date('HisYmd'));
    
        //     // Recupera a extensão do arquivo
        //     $extension = 'png';
    
        //     // Define finalmente o nome
        //     $nameFile = "{$name}.{$extension}";
    
        //     // Faz o upload:
        //     $upload = $request->image->storeAs('colmeias', $nameFile);
        //     // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
    
        //     // Verifica se NÃO deu certo o upload (Redireciona de volta)
        //     if ( !$upload ){   
        //         return response()->json([
        //             'message' => 'Colmeia criada com sucesso',
        //             'apiario' => $this->colmeia
        //         ], 400);
        //     }
                    
            
    
        //     return response()->json([
        //         'message' => 'Colmeia criada com sucesso',
        //         'apiario' => $this->colmeia
        //     ], 201);
        // }

        $this->colmeia = $this->colmeia::create([
            'nome'        => $request->nome,
            'descricao'   => $request->descricao,
            'apiario_id'  => $request->apiario_id,
        ]);

        $this->colmeia->foto = $this->colmeia->uploadImage($request);
    
        $this->colmeia->save();
        
        return response()->json([
            'message' => 'Colmeia salva com sucesso',
            'colmeia' => $this->colmeia
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
            'colmeia' => $this->colmeia 
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

        $this->colmeia = $this->colmeia->update([
            'nome'        => $request->nome,
            'descricao'   => $request->descricao,
            'apiario_id'  => $request->apiario_id,
        ]);

        if($request->foto != null){
            $this->colmeia->foto = $this->colmeia->uploadImage($request);
            $this->colmeia->save();
        }
        
        return response()->json([
            'message' => 'Colmeia salva com sucesso',
            'colmeia' => $this->colmeia
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
