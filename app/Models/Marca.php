<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome','imagem'];

    public function rules(){
        return [
         'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
         'imagem'=> 'required|file|mimes:png'
        ];
    }
    public function feedback(){
        return [
         'required'=>'o campo :attribute é obrigatório',
         'nome.unique'=> 'A marca já existe.',
         'nome.min' => 'O nome precisa ter no mínimo 3 caracteres'
        ];
    }
    public function modelos(){
        //UMA marca POSSUI MUITOS modelos
        return $this->hasMany('App\Models\Modelo');
    }
}
