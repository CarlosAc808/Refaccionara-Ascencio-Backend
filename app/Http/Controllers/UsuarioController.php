<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller{

//----------------TRAER LOS PRODUCTOS DE LA BASE DE DATOS-----
    public function getApiUsuario() {
        $usuario = Usuario::all();
        return ["usuario" => $usuario];
    }

    public function getApiUsuario_editar($id) {
        $usuario = Usuario::find($id);
        return ["usuario" => [$usuario]];
    }

//----------------AAGREGAR USUARIO ----------------------------
    public function postApiAddUsuario(Request $request) {
        // Obtenemos los parámetros de la petición
        $data = $request->all();
        // Instanciamos un objeto formulario
        $usuario = new Usuario();
        // Se asignan los parámetros de la petición al objeto
        $usuario->nombre = $data['nombre'];
        $usuario->correo = $data['correo'];
        $usuario->password = Hash::make($data['password']);
        // Se ejecuta el método save para agregar o modificar el registro
        $usuario->save();
        return response()->json(['message' => 'Usuario guardado con éxito', 'id' => $usuario->id], 201);
    }

//----------------BORRAR USUARIO---------------------------------
    public function deleteUsuario($id) {
        // Se busca el registro de la tabla
        $usuario = Usuario::find($id);
        // Se ejecuta el método delete
        $usuario->delete();
    }

    public function getApiFiltroUsuario(Request $request) {
        //Obtenemos los parametros de la peticion
        $filtro = $request->input("filtro");
        //Se usa el metodo all para obtener todos los usuarios
        $usuario = Usuario::Where('correo','LIKE',"%".$filtro."%")->get();
        return ["usuario" => $usuario];
    }

//--------------------------------------LOGIN--------------------------------
    public function postApiVerificacion(Request $request) {
        // Obtenemos los parámetros de la petición
        $data = $request->all();

        $correo = $data['correo'];
        $password = $data['password'];

        // Busca al usuario por correo
        $usuario_existe = Usuario::where('correo', $correo)->first();

        // Verifica que el usuario exista y que la contraseña coincida
        if ($usuario_existe && Hash::check($password, $usuario_existe->password)) {

            return response()->json([
                'message_exitoso' => 'Inicio de sesión exitoso',
                'id' => $usuario_existe->id,
                'correo' => $usuario_existe->correo,
                'nombre' => $usuario_existe->nombre ,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Usuario o contraseña incorrectos'
            ], 401);
        }
    }

    public function putApiUpdateUsuarios($id, Request $request){
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $nombre = $request->input('nombre', $request->get('nombre'));
        $correo = $request->input('correo', $request->get('correo'));
        $password = $request->input('password', $request->get('password'));

        if ($nombre !== null && $nombre !== '') {
            $usuario->nombre = $nombre;
        }
        if ($correo !== null && $correo !== '') {
            $usuario->correo = $correo;
        }
        // Solo actualiza la contraseña si se ingresó una nueva
        if (!empty($password)) {
            $usuario->password = Hash::make($password);
        }

        $usuario->save();

        return response()->json(['message' => 'Usuario actualizado correctamente', 'usuario' => $usuario]);
    }
}
