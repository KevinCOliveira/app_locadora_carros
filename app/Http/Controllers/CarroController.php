<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;

class CarroController extends Controller
{
    public function __construct(Carro $carro){
        $this->carro = $carro;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carroRepository = new CarroRepository($this->carro);

        if($request->has('atributos_modelo')){
            $atributos_modelo = "modelo:id,$request->atributos_modelo";
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo); 
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if ($request->has('filtro')){
            $carroRepository->filtro($request->filtro);
            }

        if($request->has('atributos')){
            $carroRepository->selectAtributos($request->atributos);
        }
        
        return response()->json($carroRepository->getResultado(), 200);
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
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->carro->rules());

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $disponivel,
            'km' => $request->km
        ]);
        return  response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show(Carro $carro)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if($modelo===null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($modelo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarroRequest  $request
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarroRequest $request, Carro $carro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carro $carro)
    {
        //
    }
}
