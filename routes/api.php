<?php

use App\Http\Controllers\ComentariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EntradasController;
use App\Http\Controllers\SalidasController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\DistribuidorController;
use App\Models\Productos;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\InventarioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta para obtener el listado de formularios
Route::get(
    "/formularios",
    [
        FormularioController::class,
        "getApiListado"
    ]
);

// Ruta para obtener un formulario por su ID
Route::get(
    "/get_formulario/{id}",
    [
        FormularioController::class,
        "getApiGetFormularioByID"
    ]
);

// Ruta para eliminar un formulario por su ID
Route::delete(
    "/delete_formulario/{id}",
    [
        FormularioController::class,
        "deleteApiEliminar"
    ]
);

Route::post(
    "/submit_formulario",
    [
        FormularioController::class,
        "postApiAddFormulario"
    ]
);

Route::put(
    "update_formulario/{id}",
    [
        FormularioController::class,
        "putApiUpdateFormulario"
    ]
);

Route::post(
    "search_producto",
    [
        FormularioController::class,
        "getApiFiltro"
    ]
);

//---------------listado_compras--------
Route::get(
    "/compras",
    [
        ComprasController::class,
        "getApiListado_Compras"
    ]
);

Route::get(
    "/get_compra/{id}",
    [
        ComprasController::class,
        "getApiGetComprasByID"
    ]
);

Route::delete(
    "/delete_compra/{id}",
    [
        ComprasController::class,
        "deleteApiEliminar_Compras"
    ]
);

Route::post(
    "/comprass",
    [
        ComprasController::class,
        "postApiAddCompras"
    ]
);

Route::put(
    "update_compra/{id}",
    [
        ComprasController::class,
        "putApiUpdateCompras"
    ]
);

//--------------------------------NUEVO REFACCIONARIA ASCENCIO-----------------------------
//-------------------------------------USUARIOS-------------------------
Route::post(
    "/usuario",
    [
        UsuarioController::class,
        "postApiAddUsuario"
    ]
);

Route::get(
    "/getUsuario",
    [
        UsuarioController::class,
        "getApiUsuario"
    ]
);

Route::delete(
    "/delete_Usuario/{id}",
    [
        UsuarioController::class,
        "deleteUsuario"
    ]
);

Route::post(
    "search_usuario",
    [
        UsuarioController::class,
        "getApiFiltroUsuario"
    ]
);

Route::post(
    "/inicio_de_sesion",
    [
        UsuarioController::class,
        "postApiVerificacion"
    ]
);

Route::match(
    ['put', 'post'],
    "update_usuarios/{id}",
    [
        UsuarioController::class,
        "putApiUpdateUsuarios"
    ]
);

Route::get(
    "/get_usuarios/{id}",
    [
        UsuarioController::class,
        "getApiUsuario_editar"
    ]
);

//-------------------------------------ENTRADAS--------------------------
Route::get(
    "/get_entradas/{id}",
    [
        EntradasController::class,
        "getApiEntrada_editar"
    ]
);

Route::put(
    "update_entradas/{id}",
    [
        EntradasController::class,
        "putApiUpdateEntradas"
    ]
);

Route::post(
    "/entradas",
    [
        EntradasController::class,
        "postApiAddEntradas"
    ]
);

Route::get(
    "/getEntradas",
    [
        EntradasController::class,
        "getApiEntrada"
    ]
);

Route::delete(
    "/delete_Entrada/{id}",
    [
        EntradasController::class,
        "deleteEntrada"
    ]
);

Route::post(
    "search_entradas",
    [
        EntradasController::class,
        "getApiFiltroEntrada"
    ]
);

//------------------------SALIDAS-----------------------------
Route::get(
    "/get_salidas/{id}",
    [
        SalidasController::class,
        "getApiSalida_editar"
    ]
);

Route::put(
    "update_salidas/{id}",
    [
        SalidasController::class,
        "putApiUpdateSalidas"
    ]
);

Route::post(
    "/salidas",
    [
        SalidasController::class,
        "postApiAddSalidas"
    ]
);

Route::get(
    "/getSalidas",
    [
        SalidasController::class,
        "getApiSalida"
    ]
);

Route::delete(
    "/delete_Salidas/{id}",
    [
        SalidasController::class,
        "deleteSalida"
    ]
);

Route::post(
    "search_salidas",
    [
        SalidasController::class,
        "getApiFiltroSalida"
    ]
);

//-----------------------PROVEEDORES-----------------------
Route::post(
    "/proveedor",
    [
        ProveedorController::class,
        "postApiAddProveedor"
    ]
);

Route::get(
    "/getProveedor",
    [
        ProveedorController::class,
        "getApiProveedor"
    ]
);

Route::delete(
    "/delete_Proveedor/{id}",
    [
        ProveedorController::class,
        "deleteProveedor"
    ]
);

Route::post(
    "search_proveedor",
    [
        ProveedorController::class,
        "getApiFiltroProveedor"
    ]
);

Route::put(
    "update_proveedores/{id}",
    [
        ProveedorController::class,
        "putApiUpdateProveedor"
    ]
);

Route::get(
    "/get_proveedores/{id}",
    [
        ProveedorController::class,
        "getApiProveedor_editar"
    ]
);

//---------------------------------PRODUCTOS-------------
Route::get(
    "/getProductos",
    [
        ProductosController::class,
        "getApiProductos"
    ]
);

Route::post(
    "search_productos",
    [
        ProductosController::class,
        "getApiFiltroProductos"
    ]
);

Route::put('/productos/{id}/stock', [ProductosController::class, 'actualizarStock']);

Route::delete(
    "/delete_producto/{id}",
    [
        ProductosController::class,
        "deleteProducto"
    ]
);

//----------------------------------------comentarios-------------------------------------
Route::post(
    "/comentarios",
    [
        ComentariosController::class,
        "AddComentarios"
    ]
);

Route::get(
    "/get_comentarios",
    [
        ComentariosController::class,
        "getApiComentarios"
    ]
);

// Agregar distribuidor
Route::post(
    "/Distribuidor",
    [
        DistribuidorController::class,
        "postApiAddDistribuidor"
    ]
);

Route::get(
    "/MostrarDistribuidor",
    [
        DistribuidorController::class,
        "getApiDistribuidor"
    ]
);

Route::get(
    "/get_distribuidor/{id}",
    [
        DistribuidorController::class,
        "getApiDistribuidor_editar"
    ]
);

Route::put(
    "/update_distribuidor/{id}",
    [
        DistribuidorController::class,
        "putApiUpdateDistribuidor"
    ]
);

Route::delete(
    "/delete_distribuidor/{id}",
    [
        DistribuidorController::class,
        "deleteDistribuidor"
    ]
);

// Agregar Categorias
Route::get(
    "/MostrarCategorias",
    [
        CategoriasController::class,
        "getApiCategorias"
    ]
);

// Agregar Inventario 
Route::post(
    "/AgregarInventario",
    [
        InventarioController::class,
        "postApiAddProducto"
    ]
);

Route::get(
    "/MostrarInventario",
    [
        InventarioController::class,
        "getApiInventario"
    ]
);

//Agregar Entradas
Route::post(
    "/Entradas",
    [
        EntradasController::class,
        "postApiAddEntradas"
    ]
);

//Agregar Salidas
Route::post(
    "/Salidas",
    [
        SalidasController::class,
        "postApiAddSalidas"
    ]
);

Route::get('/historial', [EntradasController::class, 'getHistorial']);

//------------------------------Agregar Categoria------------------------------
Route::post(
    "/AddCategoria",
    [
        CategoriasController::class,
        "postApiAddCategoria"
    ]
);
