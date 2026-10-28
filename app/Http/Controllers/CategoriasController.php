<?php

namespace App\Http\Controllers;
use App\Models\Categorias;

use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function getApiCategorias() {
        $categorias = Categorias::all();
        return response()->json([
            'categorias' => $categorias
        ]);
    }

    public function postApiAddCategoria(Request $request) {
        $data = $request->all();
        // Instanciamos un objeto formulario
        $categorias = new Categorias();
        // Se asignan los parámetros de la petición al objeto
        $categorias->nombre = $data['nombre_categoria'];

        // Se ejecuta el método save para agregar o modificar el registro
        $categorias->save();
    }
}
