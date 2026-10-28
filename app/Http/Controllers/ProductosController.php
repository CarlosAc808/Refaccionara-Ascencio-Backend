<?php

namespace App\Http\Controllers;

use App\Models\Entradas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller{

// TRAER TODOS LOS PRODUCTOS DE LA BASE DE DATOS 
    public function getApiProductos() {
        // Se usa el método all para obtener todos los formularios
        // "SELECT * FROM formularios"
        $productos = Productos::all();
        return ["productos" => $productos];
    }

    public function getApiFiltroProductos(Request $request){
        //Obtenemos los parametros de la peticion
        $filtro = $request->input("filtro");
        //Se usa el metodo all para obtener todos los usuarios
        //"SELECT * FROM usuarios WHERE nombre like '%a%'"
        $productos = Productos::Where('sku','LIKE',"%".$filtro."%")->get();
        return ["productos" => $productos];
    }

    public function actualizarStock(Request $request, $id)
    {
        $productos = Productos::find($id);

        if (!$productos) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $productos->stock = $request->input('stock');
        $productos->save();

        return response()->json(['mensaje' => 'Stock actualizado', 'stock' => $productos->stock]);
    }

    public function deleteProducto($id){
        // Se busca el registro de la tabla
        // "SELECT * FROM formularios WHERE id=1"
        $productos = Productos::find($id);
        // Se ejecuta el método delete
        // "DELETE FROM formularios WHERE id=1"
        $productos->delete();
    }
}
