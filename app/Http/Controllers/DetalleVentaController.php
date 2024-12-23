<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Medicamento;
use App\Models\EquipoMedico;
use Illuminate\Http\Request;

class DetalleVentaController extends Controller
{
    public function index()
    {
        $detalles = DetalleVenta::with(['venta', 'producto'])->get();
        return view('detalle_ventas.index', compact('detalles'));
    }

    public function show($id)
{
    $venta = Venta::with('detalleVentas')->findOrFail($id);

    $detalles = $venta->detalleVentas->map(function ($detalle) {
        $producto = $detalle->producto();
        return [
            'producto' => $producto ? $producto->nombre : 'Producto no encontrado',
            'tipo_producto' => $detalle->tipo_producto,
            'cantidad' => $detalle->cantidad,
            'precio_unitario' => $detalle->precio_unitario,
            'subtotal' => $detalle->subtotal,
        ];
    });

    return response()->json([
        'venta' => $venta,
        'detalles' => $detalles,
    ]);
}

    public function create(Venta $venta)
    {
        $medicamentos = Medicamento::all();
        $equiposMedicos = EquipoMedico::all();
        return view('detalle_ventas.create', compact('venta', 'medicamentos', 'equiposMedicos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'sucursal_id' => 'required|exists:sucursals,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|integer',
            'productos.*.tipo_producto' => 'required|in:medicamento,equipo_medico',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);
    
        $venta = Venta::create([
            'user_id' => $validatedData['user_id'],
            'sucursal_id' => $validatedData['sucursal_id'],
            'total' => 0, // Se actualizará después
        ]);
    
        $total = 0;
    
        foreach ($validatedData['productos'] as $producto) {
            // Validar existencia del producto según el tipo
            if ($producto['tipo_producto'] === 'medicamento') {
                $productoExistente = Medicamento::find($producto['id']);
            } else {
                $productoExistente = EquipoMedico::find($producto['id']);
            }
    
            if (!$productoExistente) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
    
            $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
            $total += $subtotal;
    
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto['id'],
                'tipo_producto' => $producto['tipo_producto'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $subtotal,
            ]);
        }
    
        $venta->update(['total' => $total]);
    
        return response()->json(['message' => 'Venta registrada exitosamente'], 201);
    }
    

    public function edit(DetalleVenta $detalleVenta)
    {
        $medicamentos = Medicamento::all();
        $equiposMedicos = EquipoMedico::all();
        return view('detalle_ventas.edit', compact('detalleVenta', 'medicamentos', 'equiposMedicos'));
    }

    public function update(Request $request, DetalleVenta $detalleVenta)
    {
        $request->validate([
            'cantidad' => 'nullable|integer',
            'precio_unitario' => 'nullable|numeric',
        ]);

        $detalleVenta->update([
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'subtotal' => $request->cantidad * $request->precio_unitario,
        ]);

        return redirect()->route('ventas.show', $detalleVenta->venta)->with('success', 'Detalle de venta actualizado con éxito');
    }

    public function destroy(DetalleVenta $detalleVenta)
    {
        $detalleVenta->delete();
        return redirect()->route('ventas.show', $detalleVenta->venta)->with('success', 'Detalle de venta eliminado con éxito');
    }
}

