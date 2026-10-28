<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proveedores;

class Productos extends Model
{
    use HasFactory;

    //Definimos que tabla es de la base de datos
    protected $table = "productos";

    //Definimos el primary key de la tabla
    protected $primaryKey = "id";

    //Dehabilitar los campos de created_at y update_at
    public $timestamps = false;

    //Definimos las demas columnas que tenemos en la tabla
    protected $fillable = [
        'nombre',
        "descripcion",
        "precio",
        "proveedor",
        "stock",
        "fecha",
        "imagen",
        "sku",
        "denominador"
    ];
}
