<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        
        $credenciais = $request->all(['email','password']);

        //autenticação (email e senha)
        $token = auth('api')->attempt($credenciais);
        
        if($token) // usuario autenticado com sucesso
        {
          return response()->json(['token'=>$token],200);
        } 
        else //erro de usuario ou senha 
        {
            return response()->json(['erro'=>'Usuario ou senha incorreto'],403);

            //401 = unauthorized -> não autorizado
            //403 = forbidden -> proibido (login ínvalido)
        }
        //retornar um JWT
        return 'login';
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['msg' => 'Logout foi realizado com sucesso!']);
    }
    public function refresh(){
        $token = auth('api')->refresh(); //cliente encaminhe um jwt válido
        return response()->json(['token' => $token]);
    }
    public function me(){
        return response()->json(auth()->user()); 
    }
}
