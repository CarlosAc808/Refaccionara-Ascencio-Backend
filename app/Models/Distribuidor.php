<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribuidor extends Model
{
    protected $table = 'proveedores'; 

    protected $primaryKey = 'id';

    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'ubicacion',
        'telefono',
        'email'
    ];
}
