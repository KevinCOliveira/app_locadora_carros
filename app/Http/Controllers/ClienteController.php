<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{
    public function __construct (Cliente $cliente){
        $this->cliente = $cliente;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);
        
        if($request->has('atributos')){
            $clienteRepository->selectAtributosRegistrosRelacionados($request->atributos);
        }
        
        if($request->has('filtro')){
            $clienteRepository->filtro($request->filtro);
        }


        return response()->json($clienteRepository->getResultado(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules());
        
        $cliente = $this->cliente->create(
            ['nome' => $request->nome]
        );

        return response()->json($cliente,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'],404);
        }

        return response()->json($cliente,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClienteRequest  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json(['erro'=>'não foi possivel atualizar, o recurso pesquisado não existe',404]);
        }

        if($request->method() === 'PATCH'){
            $regrasdinamicas = array();

            foreach($cliente->rules() as $input => $regra){
                if (array_key_exists($input,$request->all())){
                    $regrasdinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasdinamicas);
        }

        else {
            $request->validate($cliente->rules());
        }

        $cliente->fill($request->all());
        $cliente->save();

        return response()->json($cliente,200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if ($cliente === null){
            return response()->json(['erro'=> 'não foi possivel excluir, recurso solicitado não existe'],404);
        }

        $cliente->delete();
        return response()->json(['msg'=>'Registro foi removido com sucesso'],200);
    }
}
