<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    //
    use HasFactory;
//un arqueo puede tener muchos moviientos
    public function movimientos(){
        return $this->hasMany(MovimientoCaja::class);
    }


  
}
