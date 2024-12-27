<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DetalleVenta extends Model
{
    use HasFactory;

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    protected $fillable = [
        'venta_id',
        'producto_id',
        'tipo_producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function producto()
    {
        if ($this->tipo_producto === 'medicamento') {
            return Medicamento::find($this->producto_id);
        } elseif ($this->tipo_producto === 'equipo_medico') {
            return EquipoMedico::find($this->producto_id);
        }
        return null;
    }
}
