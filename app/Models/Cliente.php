<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{

    use HasFactory;
    protected $fillable = [
        'nombre',
        'dni',
        'telefono',
        'direccion',
    ];
    public function ventas(){
        return $this->hasMany(Venta::class,'cliente_id');
    }
    
}
