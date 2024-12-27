<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\EquipoMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Mostrar una lista de ventas.
     */
    public function index()
    {
        // Obtener todas las ventas con sus relaciones
        $ventas = Venta::with(['user', 'sucursal', 'detalleVentas'])->get();

        return view('ventas.index', compact('ventas'));
    }

    /**
     * Mostrar el formulario para crear una nueva venta.
     */
    public function create()
    {
        $usuarios = User::all();
        $clientes = Cliente::all();
        $sucursales = Sucursal::all();
        $medicamentos = Medicamento::all();
        $equipos = EquipoMedico::all();

        return view('ventas.create', compact('usuarios', 'sucursales', 'medicamentos', 'equipos', 'clientes'));
    }

    /**
     * Almacenar una nueva venta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'cliente_id' => 'required|exists:clientes,id',
            'sucursal_id' => 'required|exists:sucursals,id',
            'total' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|integer',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Crear la venta
            $venta = Venta::create([
                'user_id' => $request->user_id,
                'cliente_id' => $request->cliente_id,
                'sucursal_id' => $request->sucursal_id,
                'total' => $request->total,
            ]);

            // Guardar detalle de la venta y actualizar el stock
            foreach ($request->productos as $producto) {
                $modelo = null;

                // Determinar el modelo según el tipo de producto
                if (str_starts_with($producto['producto_id'], 'M')) {
                    $modelo = Medicamento::findOrFail(substr($producto['producto_id'], 1));
                } elseif (str_starts_with($producto['producto_id'], 'E')) {
                    $modelo = EquipoMedico::findOrFail(substr($producto['producto_id'], 1));
                }

                // Verificar si hay suficiente stock
                if ($modelo && $modelo->stock >= $producto['cantidad']) {
                    // Reducir el stock
                    $modelo->decrement('stock', $producto['cantidad']);

                    // Crear el detalle de venta
                    $venta->detalleVentas()->create([
                        'producto_id' => $producto['producto_id'],
                        'cantidad' => $producto['cantidad'],
                        'precio_unitario' => $producto['precio_unitario'],
                        'subtotal' => $producto['cantidad'] * $producto['precio_unitario'],
                    ]);
                } else {
                    throw new \Exception("Stock insuficiente para el producto: {$modelo->nombre}");
                }
            }
        });

        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }
}
