<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salidas extends Model
{
    use HasFactory;

    //Definimos que tabla es de la base de datos
    protected $table = "salidas";

    //Definimos el primary key de la tabla
    protected $primaryKey = "id";

    //Dehabilitar los campos de created_at y update_at
    public $timestamps = false;

    //Definimos las demas columnas que tenemos en la tabla
    protected $fillable = [
        'producto_id',
        "cantidad",
        "fecha",
        "precio_compra",
    ];

    public function producto() {
        return $this->belongsTo(inventario::class, 'producto_id');
    }
}
