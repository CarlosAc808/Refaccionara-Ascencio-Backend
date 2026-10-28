<?php

namespace App\Http\Controllers;

use App\Models\formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormularioController extends Controller{

     public function getApiListado() {
        // Se usa el método all para obtener todos los formularios
        // "SELECT * FROM formularios"
        $formularios = Formulario::all();
        return ["formularios" => $formularios];
    }

    // Agregamos un parámetro
    public function getApiGetFormularioByID($id = null) {
        // Ejecutamos el método find para buscar por el pk
        // "SELECT * FROM formularios WHERE id=3"
        $formulario = Formulario::find($id);
        return $formulario;
    }

    public function deleteApiEliminar($id) {
        // Se busca el registro de la tabla
        // "SELECT * FROM formularios WHERE id=1"
        $formulario = Formulario::find($id);

        // Se borra la imagen
        if (!empty($formulario->imagen)) {
            Storage::delete(public_path('imagenes_formularios').'/'.$formulario->imagen);
        }

        // Se ejecuta el método delete
        // "DELETE FROM formularios WHERE id=1"
        $formulario->delete();
    }

    public function postApiAddFormulario(Request $request) {
        // Obtenemos los parámetros de la petición
        $data = $request->all();
        // Establecemos un nombre para la imagen
        $ruta_archivo_original = null;

        // Instanciamos un objeto formulario
        $formulario = new Formulario();

        // Validamos si la imagen se está enviando
        if ($request->hasFile('imagen')) {
            // Generamos un nombre aleatorio y concatenamos la extensión de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            // Movemos el archivo a la carpeta pública con el nombre
            $request->imagen->move(public_path('imagenes_formularios'), $nombreImagen);
            // Asignamos el nombre del archivo
            $ruta_archivo_original = $nombreImagen;
        }

        // Se asignan los parámetros de la petición al objeto
        $formulario->nombre = $data['nombre'];
        $formulario->descripcion = $data['descripcion'];
        $formulario->precio = $data['precio'];

        if ($request->hasFile('imagen')) {
            $formulario->imagen = $ruta_archivo_original;
        }

        // Se ejecuta el método save para agregar o modificar el registro
        $formulario->save();
    }

    public function putApiUpdateFormulario($id, Request $request) {
        // Obtenemos los parámetros de la petición
        $data = $request->all();
        $ruta_archivo_original = null;
    
        // Se busca el registro con el id
        $formulario = Formulario::find($id);
    
        // Validamos si la imagen se está enviando
        if ($request->hasFile('imagen')) {
            // Validamos si hay una imagen en la base de datos
            if ($formulario->imagen != null) {
                // Eliminar la imagen que se tiene en la base de datos
                Storage::delete(public_path('imagenes_formularios').'/'.$formulario->imagen);
            }
            // Generamos un nombre aleatorio y concatenamos la extensión de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            // Movemos el archivo a la carpeta pública con el nombre
            $request->imagen->move(public_path('imagenes_formularios'), $nombreImagen);
            // Asignamos el nombre del archivo
            $ruta_archivo_original = $nombreImagen;
        }
    
        // Se asignan los parámetros de la petición al objeto
        $formulario->nombre = $data['nombre'];
        $formulario->descripcion = $data['descripcion'];
        $formulario->precio = $data['precio'];
    
        if ($request->hasFile('imagen')) {
            $formulario->imagen = $ruta_archivo_original;
        }
    
        // Se ejecuta el método save para agregar o modificar el registro
        $formulario->save();
    }

    public function getApiFiltro(Request $request) {
        //Obtenemos los parametros de la peticion
        $filtro = $request->input("filtro");
        //Se usa el metodo all para obtener todos los usuarios
        //"SELECT * FROM usuarios WHERE nombre like '%a%'"
        $formulario = Formulario::Where('nombre','LIKE',"%".$filtro."%")->get();
        return ["formularios" => $formulario];
    }
}
