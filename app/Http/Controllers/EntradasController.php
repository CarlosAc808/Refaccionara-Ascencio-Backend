<?php

namespace App\Http\Controllers;

use App\Models\Entradas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;
use App\Models\inventario;
use Illuminate\Support\Facades\DB;

class EntradasController extends Controller{

/*
// TRAER TODOS LOS PRODUCTOS DE LA BASE DE DATOS 

    public function getApiEntrada() {
    $entradas = Entradas::all()->map(function ($entrada) {
        // Formatea la fecha como 'YYYY-MM-DD' para evitar problemas de zona horaria
        $entrada->fecha = \Carbon\Carbon::parse($entrada->fecha)->format('Y-m-d');
        return $entrada;
    });

    return ["entradas" => $entradas];
    }

    public function getApiEntrada_editar($id) {
    $entradas = Entradas::find($id);
    return ["entradas" => [$entradas]];
    }

//----------------AGREGAR ENTRADAS ----------------------------
    public function postApiAddEntradas(Request $request) {
        // Obtenemos los parámetros de la petición
        $data = $request->all();
        // Establecemos un nombre para la imagen
        $ruta_archivo_original = null;

        // Instanciamos un objeto formulario
        $entradas = new Entradas();

        // Validamos si la imagen se está enviando
        if ($request->hasFile('imagen')) {
            // Generamos un nombre aleatorio y concatenamos la extensión de la imagen
            $nombreImagen = time().'.'.$request->imagen->extension();
            // Movemos el archivo a la carpeta pública con el nombre
            $request->imagen->move(public_path('imagenes_entradas'), $nombreImagen);
            // Asignamos el nombre del archivo
            $ruta_archivo_original = $nombreImagen;
        }

        // Se asignan los parámetros de la petición al objeto
        $entradas->nombre = $data['nombre'];
        $entradas->sku = $data['sku'];
        $entradas->descripcion = $data['descripcion'];
        $entradas->precio = $data['precio'];
        $entradas->proveedor = $data['proveedor'];
        $entradas->stock = $data['stock'];
        $entradas->denominador = $data['denominador'];
        $entradas->fecha = $data['fecha'];

        if ($request->hasFile('imagen')) {
            $entradas->imagen = $ruta_archivo_original;
        }

        // Se ejecuta el método save para agregar o modificar el registro
        $entradas->save();

        //aqui va la copia a la tabla productos
        $producto = Productos::where('sku', $data['sku'])->first();

        if ($producto) {
            $producto->nombre = $data['nombre'];
            $producto->descripcion = $data['descripcion'];
            $producto->precio = $data['precio'];
            $producto->proveedor = $data['proveedor'];
            $producto->stock += $data['stock']; // ← Aquí se suma el nuevo stock
            $producto->denominador = $data['denominador'];
            $producto->fecha = $data['fecha'];

            if ($ruta_archivo_original !== null) {
                $producto->imagen = $ruta_archivo_original;
            }

            $producto->save();
        } else {
            // Si no existe, lo creamos
            $producto = new Productos();
            $producto->nombre = $data['nombre'];
            $producto->sku = $data['sku'];
            $producto->descripcion = $data['descripcion'];
            $producto->precio = $data['precio'];
            $producto->proveedor = $data['proveedor'];
            $producto->stock = $data['stock'];
            $producto->denominador = $data['denominador'];
            $producto->fecha = $data['fecha'];
            
            if ($ruta_archivo_original !== null) {
                $producto->imagen = $ruta_archivo_original;
            }

            $producto->save();
        }

        return response()->json(['message' => 'Entrada registrada y producto actualizado correctamente']);
    }

        //----------------BORRAR SALIDA---------------------------------
        public function deleteEntrada($id) {
        $entradas = Entradas::find($id);
        $entradas->delete();
    }

        public function getApiFiltroEntrada(Request $request) {
        $filtro = $request->input("filtro");
        $entradas = Entradas::Where('sku','LIKE',"%".$filtro."%")->get();
        return ["entradas" => $entradas];
    }

        public function putApiUpdateEntradas($id, Request $request) {
        $data = $request->all();
        $ruta_archivo_original = null;
    
        $entradas = Entradas::find($id);
    
        if ($request->hasFile('imagen')) {
            if ($entradas->imagen != null) {
                Storage::delete(public_path('imagenes_entradas').'/'.$entradas->imagen);
            }
            $nombreImagen = time().'.'.$request->imagen->extension();
            $request->imagen->move(public_path('imagenes_entradas'), $nombreImagen);
            $ruta_archivo_original = $nombreImagen;
        }
    
        $entradas->nombre = $data['nombre'];
        $entradas->sku = $data['sku'];
        $entradas->descripcion = $data['descripcion'];
        $entradas->precio = $data['precio'];
        $entradas->proveedor = $data['proveedor'];
        $entradas->stock = $data['stock'];
        $entradas->denominador = $data['denominador'];
        $entradas->fecha = $data['fecha'];
    
        if ($request->hasFile('imagen')) {
            $entradas->imagen = $ruta_archivo_original;
        }
    
        $entradas->save();

        $producto = Productos::where('sku', $data['sku'])->first();

        if ($producto) {
            $producto->nombre = $data['nombre'];
            $producto->descripcion = $data['descripcion'];
            $producto->precio = $data['precio'];
            $producto->proveedor = $data['proveedor'];
            $producto->stock = $data['stock'];
            $producto->denominador = $data['denominador'];
            $producto->fecha = $data['fecha'];

            if ($ruta_archivo_original !== null) {
                $producto->imagen = $ruta_archivo_original;
            }

            $producto->save();
        }
        return response()->json(['message' => 'Entrada actualizado correctamente']);
    }
*/

//------------------------------Nuevo--------------------------------------------

    public function postApiAddEntradas(Request $request){
        $data = $request->all();

        // ✅ guardar entrada
        $entrada = new Entradas();
        $entrada->producto_id = $data['select_producto'];
        $entrada->cantidad = $data['cantidad_producto'];
        $entrada->fecha = $data['fecha_movimiento'];
        $entrada->precio_compra = $data['precio_producto'];
        $entrada->proveedor_id = $data['proveedor_id'];
        $entrada->save();

        // 🔥 sumar stock
        $producto = inventario::find($request->select_producto);
        $producto->cantidad += $request->cantidad_producto;
        $producto->save();

        return response()->json([
            "mensaje" => "Entrada registrada correctamente"
        ]);
    }

    public function getHistorial()
    {
        $historial = DB::select("
            SELECT 
                e.id,
                p.nombre AS producto,
                e.cantidad,
                e.fecha AS fecha_movimiento,
                'Entrada' AS tipo,
                e.precio_compra
            FROM entradas e
            JOIN productos p ON e.producto_id = p.id

            UNION ALL

            SELECT 
                s.id,
                p.nombre AS producto,
                s.cantidad,
                s.fecha AS fecha_movimiento,
                'Salida' AS tipo,
                s.precio_compra
            FROM salidas s
            JOIN productos p ON s.producto_id = p.id

            ORDER BY fecha_movimiento DESC
        ");

        return response()->json($historial);
    }
}
