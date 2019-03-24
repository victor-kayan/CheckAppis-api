<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Intervencao;

class IntervencaoController extends Controller
{
    private $intervencao;

    public function __construct(Intervencao $intervencao){
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

    public function indexByApiario($apiario_id){
        // $intervencoes = $this->intervencao->; 
        $intervencoes = Intervencao::where('apiario_id', $apiario_id)->where('is_concluido', true)->orderBy('created_at', 'ASC')->get();
        foreach ($intervencoes as $intervencao) {
            $intervencao->tecnico = \App\Model\User::where('id', $intervencao->tecnico_id)->first();
        }

        return response()->json([
            'message' => 'Lista de intervencaos',
            'intervencoes' => $intervencoes
        ], 200);
    }

    public function concluirIntervencao($intervencao_id){
        $intervencaosColmeia =  \App\Model\IntervencaoColmeia::where('intervencao_id', $intervencao_id)->count();

        return $intervencaosColmeia;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
