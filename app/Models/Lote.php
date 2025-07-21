<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lote extends Model
{
    protected $fillable = [
        'producto_id',
        'numero_lote',
        'fecha_ingreso',
        'fecha_vencimiento',
        'cantidad',
        'precio_compra',  
        'precio_venta',   
         'created_at',
    'updated_at'
    ];
    protected $dates = [
    'fecha_ingreso',
    'fecha_vencimiento',
    'created_at',
    'updated_at'
];



protected $casts = [
    'fecha_ingreso' => 'datetime',
    'fecha_vencimiento' => 'datetime',
];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function scopeActivos($query)
{
    return $query->where('fecha_vencimiento', '>=', now());
}

public function scopeVencidos($query)
{
    return $query->where('fecha_vencimiento', '<', now());
}
}
