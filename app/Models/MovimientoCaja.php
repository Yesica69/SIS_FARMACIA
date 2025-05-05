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
}
