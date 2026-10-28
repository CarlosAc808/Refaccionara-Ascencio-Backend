<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribuidor;

class DistribuidorController extends Controller
{
    public function postApiAddDistribuidor(Request $request) {
        $data = $request->all();
        // Instanciamos un objeto formulario
        $distribuidores = new Distribuidor();
        // Se asignan los parámetros de la petición al objeto
        $distribuidores->nombre = $data['nombre_distribuidor'];
        $distribuidores->ubicacion = $data['ubicacion_distribuidor'];
        $distribuidores->telefono = $data['telefono_distribuidor'];
        $distribuidores->email = $data['email_distribuidor'];

        // Se ejecuta el método save para agregar o modificar el registro
        $distribuidores->save();
    }

    public function getApiDistribuidor() {
        $distribuidores = Distribuidor::all();
        return ["distribuidores" => $distribuidores];
    }

    public function getApiDistribuidor_editar($id) {
        $distribuidor = Distribuidor::find($id);
        return ["distribuidor" => [$distribuidor]];
    }

    public function putApiUpdateDistribuidor($id, Request $request) {
        $distribuidor = Distribuidor::find($id);
        if (!$distribuidor) {
            return response()->json(['message' => 'Distribuidor no encontrado'], 404);
        }
        $data = $request->all();
        if (isset($data['nombre_distribuidor'])) $distribuidor->nombre = $data['nombre_distribuidor'];
        if (isset($data['ubicacion_distribuidor'])) $distribuidor->ubicacion = $data['ubicacion_distribuidor'];
        if (isset($data['telefono_distribuidor'])) $distribuidor->telefono = $data['telefono_distribuidor'];
        if (isset($data['email_distribuidor'])) $distribuidor->email = $data['email_distribuidor'];
        $distribuidor->save();
        return response()->json(['message' => 'Distribuidor actualizado correctamente']);
    }

    public function deleteDistribuidor($id) {
        $distribuidor = Distribuidor::find($id);
        if ($distribuidor) {
            $distribuidor->delete();
            return response()->json(['message' => 'Distribuidor eliminado con éxito']);
        }
        return response()->json(['message' => 'Distribuidor no encontrado'], 404);
    }
}
