<?php

namespace App\Http\Controllers;

use App\Models\Salidas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\inventario;

class SalidasController extends Controller{

/*
//----------------TRAER LOS PRODUCTOS DE LA BASE DE DATOS-----
    public function getApiSalida() {
    $salidas = Salidas::all()->map(function ($salida) {
        // Formatea la fecha en 'YYYY-MM-DD'
        $salida->fecha = \Carbon\Carbon::parse($salida->fecha)->format('Y-m-d');
        return $salida;
    });

    return ["salidas" => $salidas];
    }

    public function getApiSalida_editar($id) {
    $salidas = Salidas::find($id);
    return ["salidas" => [$salidas]];
    }

//----------------AGREGAR SALIDAS ----------------------------
    public function postApiAddSalidas(Request $request) {
        // Obtenemos los parámetros de la petición
        $data = $request->all();
        // Establecemos un nombre para la imagen
        $ruta_archivo_original = null;

        // Instanciamos un objeto formulario
        $salidas = new Salidas();

        // Validamos si la imagen se está enviando
        if ($request->hasFile('imagen')) {
            // Generamos un nombre aleatorio y concatenamos la extensión de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            // Movemos el archivo a la carpeta pública con el nombre
            $request->imagen->move(public_path('imagenes_salidas'), $nombreImagen);
            // Asignamos el nombre del archivo
            $ruta_archivo_original = $nombreImagen;
        }

        // Se asignan los parámetros de la petición al objeto
        $salidas->nombre = $data['nombre'];
        $salidas->sku = $data['sku'];
        $salidas->precio = $data['precio'];
        $salidas->proveedor = $data['proveedor'];
        $salidas->cantidad = $data['cantidad'];
        $salidas->denominador = $data['denominador'];
        $salidas->fecha = $data['fecha'];

        if ($request->hasFile('imagen')) {
            $salidas->imagen = $ruta_archivo_original;
        }

        // Se ejecuta el método save para agregar o modificar el registro
        $salidas->save();

        // Buscar el producto por SKU
        $producto = Productos::where('sku', $data['sku'])->first();

        if ($producto) {
            // Restar la cantidad de la salida al stock actual
            $producto->stock = max(0, ($producto->stock ?? 0) - intval($data['cantidad']));
            $producto->save();
        }
    }

    //----------------BORRAR SALIDA---------------------------------
    public function deleteSalida($id) {
        $salidas = Salidas::find($id);
        $salidas->delete();
    }

    //----------------BUSQUEDA------------------------------------------
    public function getApiFiltroSalida(Request $request) {
        $filtro = $request->input("filtro");
        $salidas = Salidas::Where('sku','LIKE',"%".$filtro."%")->get();
        return ["salidas" => $salidas];
    }

    public function putApiUpdateSalidas($id, Request $request) {
        $data = $request->all();
        $ruta_archivo_original = null;
    
        $salidas = Salidas::find($id);
    
        if ($request->hasFile('imagen')) {
            if ($salidas->imagen != null) {
                Storage::delete(public_path('imagenes_salidas').'/'.$salidas->imagen);
            }
            $nombreImagen = time().'.'.$request->imagen->extension();
            $request->imagen->move(public_path('imagenes_salidas'), $nombreImagen);
            $ruta_archivo_original = $nombreImagen;
        }

        $salidas->nombre = $data['nombre'];
        $salidas->sku = $data['sku'];
        $salidas->precio = $data['precio'];
        $salidas->proveedor = $data['proveedor'];
        $salidas->cantidad = $data['cantidad'];
        $salidas->denominador = $data['denominador'];
        $salidas->fecha = $data['fecha'];
    
        if ($request->hasFile('imagen')) {
            $salidas->imagen = $ruta_archivo_original;
        }
    
        $salidas->save();
        return response()->json(['message' => 'salida actualizado correctamente']);

        $producto = Productos::where('sku', $data['sku'])->first();

        if ($producto) {
            $producto->stock = ($producto->stock ?? 0) + $cantidad_antigua - intval($data['cantidad']);
            if ($producto->stock < 0) {
                $producto->stock = 0;
            }
            $producto->save();
        }
    }
*/

//----------------Nuevo------------------------------------------------
    public function postApiAddSalidas(Request $request) {
        $data = $request->all();

        // ✅ Crear salida
        $salida = new Salidas();
        $salida->producto_id = $data['select_producto'];
        $salida->cantidad = $data['cantidad_producto'];
        $salida->fecha = $data['fecha_movimiento'];
        $salida->precio_compra = $data['precio_producto'];
        $salida->save(); // 🔥 guardar salida primero

        // 🔥 RESTAR STOCK (producto)
        $producto = inventario::find($request->select_producto);

        $producto->cantidad -= $request->cantidad_producto;
        $producto->save();

        return response()->json(["mensaje" => "Salida registrada"]);
    }
}
