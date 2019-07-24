<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Intervencao;
use App\Model\User;
use Illuminate\Http\Request;

class IntervencaoController extends Controller
{

    public function __construct(Intervencao $intervencao)
    {
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

    public function indexByUserLogged()
    {
        $intervencoes = Intervencao::whereHas('apiario', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->where('is_concluido', false)->with('apiario')->orderBy('created_at', 'DESC')->get();

        foreach ($intervencoes as $intervencao) {
            $intervencao->tecnico = User::find($intervencao->tecnico_id);
        }

        return response()->json([
            'message' => 'Lista de irvencaos',
            'intervencoes' => $intervencoes,
        ], 200);
    }

    public function concluirIntervencao($intervencao_id)
    {
        Intervencao::findOrFail($intervencao_id)->update(['is_concluido' => true]);
        return response()->json([
            'message' => 'Itervencao concluida',
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
