<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\IntervencaoColmeia;

class IntervencaoColmeiaController extends Controller
{
    private $intervencao;

    public function __construct(IntervencaoColmeia $intervencao){
        $this->$intervencao = $intervencao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function indexByIntervencao($intervencao_id){
        $intervencoes = IntervencaoColmeia::where('intervencao_id', $intervencao_id)->where('is_concluido', false)->with('colmeia')->orderBy('created_at', 'ASC')->get();

        return response()->json([
            'message' => 'Lista de intervencaos',
            'intervencoes' => $intervencoes
        ], 200);
    }

    public function concluirIntervencao($intervencao_id){
        // return $intervencao_id;
        $intervencao = IntervencaoColmeia::find($intervencao_id)->update(['is_concluido' => true]);
        // $intervencao = IntervencaoColmeia::findOrFail($colmeia_id);

        return response()->json([
            'message' => 'Itervencao concluida',
            'intervencao' => $intervencao
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
