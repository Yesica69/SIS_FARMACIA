<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    use HasFactory;
    //un movimiento puede tener un arqueo
public function caja(){
    return $this->belongsTo(Caja::class);
}

public function compra()
{
    return $this->belongsTo(Compra::class);
}

public function venta()
{
    return $this->belongsTo(Venta::class);
}
}
