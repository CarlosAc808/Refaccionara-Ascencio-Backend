<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventario;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function postApiAddProducto(Request $request) {
        // Obtenemos todos los datos enviados
        $data = $request->all();

        // Variable para la imagen
        $rutaImagen = null;

        // Creamos el objeto inventario
        $producto = new inventario();

        // Validamos si se está enviando una imagen
        if ($request->hasFile('imagen_producto')) {
            $nombreImagen = time() . '.' . $request->imagen_producto->extension();
            $request->imagen_producto->move(public_path('imagenes_productos'), $nombreImagen);
            $rutaImagen = 'imagenes_productos/' . $nombreImagen; // ← ruta correcta
        }

        // Asignamos los datos al objeto
        $producto->nombre = $data['nombre_producto'];
        $producto->descripcion = $data['descripcion']; // puedes usar otra columna si quieres
        $producto->precio =   $data['precio_Producto'];
        $producto->categoria_id = $data['categoria_id'];
        $producto->proveedor_id = $data['proveedor_id_producto'];

        // Asignamos la imagen si existe
        if ($rutaImagen) {
            $producto->imagen = $rutaImagen;
        }

        // Guardamos el registro
        $producto->save();

        // Retornamos respuesta JSON
        return response()->json(['success' => true, 'producto' => $producto]);
    }

    public function getApiInventario() {
        $producto = DB::select("
            SELECT 
                p.*,
                c.nombre AS categoria
            FROM productos p
            JOIN categorias c ON p.categoria_id = c.id
        ");

        return ["producto" => $producto];
    }
}
