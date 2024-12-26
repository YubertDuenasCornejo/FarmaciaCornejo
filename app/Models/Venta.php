<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'cliente_id',
        'total',
    ];

    // Relación con usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con sucursales
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    // Relación con detalle de ventas
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
