<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Repositories\MarcaRepository;

class MarcaController extends Controller
{
    public function __construct(Marca $marca){
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('atributos_modelos')){
            $atributos_modelos = "modelos:id,$request->atributos_modelos";
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos); 
        } else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if ($request->has('filtro')){
            $marcaRepository->filtro($request->filtro);
            }

        if($request->has('atributos')){
            $marcaRepository->selectAtributos($request->atributos);
        }
        
        //$marcas = Marca::all();
        //$marcas = $this->marca->with('modelos')->get();
        
        return response()->json($marcaRepository->getResultado(), 200);
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
    
        $request->validate($this->marca->rules(), $this->marca->feedback());

        //$marca = Marca::create($request->all());
        //dd($request->nome);
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens','public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn 
        ]);
        return  response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);

        if($marca===null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // print_r($request->all());
        // echo '<hr>';
        // print_r($marca->getAttributes());
        $marca = $this->marca->find($id); 

        if ($marca === null){
            return response()->json(['erro' => '    '], 404);
        }

        if($request->method() === 'PATCH'){
            
            $regrasDinamicas=array();

            foreach($marca->rules() as $input => $regra){

                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }  
            }
            $request->validate($regrasDinamicas, $marca->feedback());  
        }
        else
        {
            $request->validate($marca->rules(), $marca->feedback());
        }

        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
        }

        
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens','public');

        $marca->fill($request->all()); //pega parametros do array e sobreescreve atributos do objeto
        $marca->imagem = $imagem_urn;
        // $marca->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);
        $marca->save();

        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $marca = $this->marca->find($id); 
        if ($marca === null){
            return  response()->json(['erro'=>'Não foi possivel remover. O recurso solicitado não existe'], 404);
        }

        Storage::disk('public')->delete($marca->imagem);

        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}
