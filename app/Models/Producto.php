<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Producto extends Model
{
    use HasFactory;
   
     // eelación con la tabla 'categorias' (muchos productos pueden pertenecer a una categoría)
     public function categoria()
     {
         return $this->belongsTo(Categoria::class);
     }
 
     // relación con la tabla 'laboratorios' (muchos productos pueden pertenecer a un laboratorio)
     public function laboratorio()
     {
         return $this->belongsTo(Laboratorio::class);
     }

     
     //un producto puede permanecer a varias compraas
     public function compras()
     {
         return $this->hasMany(Compras::class);
     }
}
