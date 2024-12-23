<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedore extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
    ];

    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class,'proveedore_id');
    }

    public function equiposMedicos(): HasMany
    {
        return $this->hasMany(EquipoMedico::class, 'proveedore_id');    
    }
}
