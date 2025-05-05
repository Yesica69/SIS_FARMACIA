<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //

    use HasFactory, HasRoles;

    //una ccompra tiene muchos detalle de esa compra
    public function detallesVenta(){
        return $this->hasMany(DetalleVenta::class);

    }

    public function cliente()
{
    return $this->belongsTo(Cliente::class);
}

}
