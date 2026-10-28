<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
    protected $table = 'productos'; 

    protected $primaryKey = 'id';

    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'categoria_id',
        'proveedor_id',
    ];

    // Relación con categorías
    public function categoria() {
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }

    public function proveedor() {
        return $this->belongsTo(Proveedores::class, 'proveedor_id');
    }

    public function entradas() {
        return $this->hasMany(entradas::class);
    }

    public function salidas() {
        return $this->hasMany(salidas::class);
    }
}
