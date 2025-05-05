<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{    use HasFactory;
    use HasRoles;
    //relacion una categoria  puede tener varios productos
    public function productos(){
        return $this->hasMany(Producto::class);
    }

}
