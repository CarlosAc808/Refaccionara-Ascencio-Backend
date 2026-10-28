<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller{

//---------------TRAER LOS PRODUCTOS DE LA BASE DE DATOS-------
    public function getApiProveedor() {
        $proveedores = Proveedores::all();
        return ["proveedores" => $proveedores];
    }

    public function getApiProveedor_editar($id) {
        $proveedor = Proveedores::find($id);
        return ["proveedores" => [$proveedor]];
    }

//----------------AGREGAR USUARIO ----------------------------
    public function postApiAddProveedor(Request $request) {
        $data = $request->all();
        // Instanciamos un objeto formulario
        $proveedores = new Proveedores();
        // Se asignan los parámetros de la petición al objeto
        $proveedores->nombre = $data['nombre'];
        $proveedores->ubicacion = $data['ubicacion'];
        $proveedores->telefono = $data['telefono'];
        // Se ejecuta el método save para agregar o modificar el registro
        $proveedores->save();
    }

//----------------BORRAR PROVEEDOR---------------------------------
    public function deleteProveedor($id) {
        // Se busca el registro de la tabla
        // "SELECT * FROM formularios WHERE id=1"
        $proveedores = Proveedores::find($id);
        // Se ejecuta el método delete
        // "DELETE FROM formularios WHERE id=1"
        $proveedores->delete();
    }

//----------------BUSQUEDA------------------------------------------
    public function getApiFiltroProveedor(Request $request) {
        //Obtenemos los parametros de la peticion
        $filtro = $request->input("filtro");
        //Se usa el metodo all para obtener todos los usuarios
        //"SELECT * FROM usuarios WHERE nombre like '%a%'"
        $proveedores = Proveedores::Where('nombre','LIKE',"%".$filtro."%")->get();
        return ["proveedores" => $proveedores];
    }

    public function putApiUpdateProveedor($id, Request $request){
        $data = $request->all();

        $proveedores = Proveedores::find($id);
        $proveedores->nombre = $data['nombre'];        // name del input "nombre"
        $proveedores->ubicacion = $data['ubicacion'];
        $proveedores->telefono = $data['telefono'];

        $proveedores->save();

        return response()->json(['message' => 'Proveedor actualizado correctamente']);
    }
}
