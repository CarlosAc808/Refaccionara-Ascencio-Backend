<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComentariosController extends Controller{

    public function getApiComentarios(){
        $comentarios = Comentarios::all();
        return ["comentario" => $comentarios];
    }

    public function AddComentarios(Request $request){
        $data = $request->all();
        // Instanciamos un objeto formulario
        $comentarios = new Comentarios();
        // Se asignan los parámetros de la petición al objeto
        $comentarios->comentarios= $data['comentario'];
        // Se ejecuta el método save para agregar o modificar el registro
        $comentarios->save();
    }
}
