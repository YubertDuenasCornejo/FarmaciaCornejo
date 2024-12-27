<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\EquipoMedico;
use App\Models\DetalleVenta;
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
        // Decodificar el JSON de productos y agregarlo al request para validación
        $productos = json_decode($request->productos, true);
        $request->merge(['productos' => $productos]);

        // Validación de los datos
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cliente_id' => 'required|exists:clientes,id',
            'sucursal_id' => 'required|exists:sucursals,id',
            'total' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|string',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Crear la venta
        $venta = Venta::create([
            'user_id' => $validatedData['user_id'],
            'cliente_id' => $validatedData['cliente_id'],
            'sucursal_id' => $validatedData['sucursal_id'],
            'total' => $validatedData['total'],
        ]);

        // Crear los detalles de la venta
        foreach ($validatedData['productos'] as $producto) {
            // Determinar tipo de producto según el prefijo del ID
            $tipoProducto = null;
            $modelo = null;

            if (str_starts_with($producto['producto_id'], 'M')) {
                $tipoProducto = 'medicamento';
                $idProducto = substr($producto['producto_id'], 1);
                $modelo = Medicamento::findOrFail($idProducto);
            } elseif (str_starts_with($producto['producto_id'], 'E')) {
                $tipoProducto = 'equipo_medico';
                $idProducto = substr($producto['producto_id'], 1);
                $modelo = EquipoMedico::findOrFail($idProducto);
            }

            // Validar stock y actualizar
            if ($modelo && $modelo->stock >= $producto['cantidad']) {
                $modelo->decrement('stock', $producto['cantidad']);

                // Crear el detalle de venta
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $idProducto,
                    'tipo_producto' => $tipoProducto,
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $producto['precio_unitario'],
                    'subtotal' => $producto['cantidad'] * $producto['precio_unitario'],
                ]);
            } else {
                throw new \Exception("Stock insuficiente para el producto seleccionado.");
            }
        }

        // Redirección con mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }
}
