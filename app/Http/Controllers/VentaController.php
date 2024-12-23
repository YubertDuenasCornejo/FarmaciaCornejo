<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Medicamento;
use App\Models\EquipoMedico;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the ventas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todas las ventas con las relaciones necesarias
        $ventas = Venta::with(['user', 'sucursal', 'detalles'])->paginate(10);
    
        // Retornar la vista con las ventas
        return view('ventas.index', compact('ventas'));
    }
    

    /**
     * Show the form for creating a new venta.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtener todas las sucursales, usuarios y productos disponibles
        $sucursales = Sucursal::all();
        $usuarios = User::all();
        $medicamentos = Medicamento::all();
        $equipos_medicos = EquipoMedico::all();

        // Retornar la vista de creación con los datos de sucursales, usuarios, medicamentos y equipos médicos
        return view('ventas.create', compact('sucursales', 'usuarios', 'medicamentos', 'equiposMedicos'));
    }

    /**
     * Store a newly created venta in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos de la venta
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sucursal_id' => 'required|exists:sucursals,id',
            'total' => 'required|numeric|min:0',
            'producto_tipo' => 'required|in:medicamento,equipo_medico',
            'producto_id' => 'required|exists:medicamentos,id,|exists:equipo_medicos,id', // Validar según tipo de producto
            'cantidad' => 'required|numeric|min:1',
            'precio' => 'required|numeric|min:0',
        ]);

        // Crear una nueva venta
        $venta = Venta::create([
            'user_id' => $request->user_id,
            'sucursal_id' => $request->sucursal_id,
            'total' => $request->total,
        ]);

        // Registrar los detalles de la venta (producto, cantidad, precio)
        if ($request->producto_tipo == 'medicamento') {
            $producto = Medicamento::find($request->producto_id);

            // Verificar si hay suficiente stock
            if ($producto->stock < $request->cantidad) {
                return back()->withErrors('No hay suficiente stock para este medicamento.');
            }

            // Restar el stock del medicamento
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Registrar el detalle de la venta
            $venta->detalles()->create([
                'medicamento_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio' => $request->precio,
            ]);

        } elseif ($request->producto_tipo == 'equipo_medico') {
            $producto = EquipoMedico::find($request->producto_id);

            // Verificar si hay suficiente stock
            if ($producto->stock < $request->cantidad) {
                return back()->withErrors('No hay suficiente stock para este equipo médico.');
            }

            // Restar el stock del equipo médico
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Registrar el detalle de la venta
            $venta->detalles()->create([
                'equipo_medico_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio' => $request->precio,
            ]);
        }

        // Redirigir al listado de ventas con mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito');
    }

    /**
     * Display the specified venta.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        // Cargar la venta con sus relaciones (usuario, sucursal, detalles)
        $venta->load(['user', 'sucursal', 'detalles']);

        // Retornar la vista de detalle de venta
        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified venta.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        // Obtener todas las sucursales, usuarios, medicamentos y equipos médicos
        $sucursales = Sucursal::all();
        $usuarios = User::all();
        $medicamentos = Medicamento::all();
        $equipos_medicos = EquipoMedico::all();

        // Retornar la vista de edición con los datos de la venta, sucursales, usuarios, medicamentos y equipos médicos
        return view('ventas.edit', compact('venta', 'sucursales', 'usuarios', 'medicamentos', 'equipos_medicos'));
    }

    /**
     * Update the specified venta in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        // Validar los datos de la venta
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sucursal_id' => 'required|exists:sucursals,id',
            'total' => 'required|numeric|min:0',
            'producto_tipo' => 'required|in:medicamento,equipo_medico',
            'producto_id' => 'required|exists:medicamentos,id,|exists:equipo_medicos,id', // Validar según tipo de producto
            'cantidad' => 'required|numeric|min:1',
            'precio' => 'required|numeric|min:0',
        ]);

        // Actualizar los datos de la venta
        $venta->update($request->only(['user_id', 'sucursal_id', 'total']));

        // Actualizar los detalles de la venta según el tipo de producto
        if ($request->producto_tipo == 'medicamento') {
            $producto = Medicamento::find($request->producto_id);
            // Verificar si hay suficiente stock
            if ($producto->stock < $request->cantidad) {
                return back()->withErrors('No hay suficiente stock para este medicamento.');
            }

            // Restar el stock del medicamento
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Crear o actualizar el detalle
            $venta->detalles()->updateOrCreate(
                ['medicamento_id' => $producto->id],
                ['cantidad' => $request->cantidad, 'precio' => $request->precio]
            );

        } elseif ($request->producto_tipo == 'equipo_medico') {
            $producto = EquipoMedico::find($request->producto_id);
            // Verificar si hay suficiente stock
            if ($producto->stock < $request->cantidad) {
                return back()->withErrors('No hay suficiente stock para este equipo médico.');
            }

            // Restar el stock del equipo médico
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Crear o actualizar el detalle
            $venta->detalles()->updateOrCreate(
                ['equipo_medico_id' => $producto->id],
                ['cantidad' => $request->cantidad, 'precio' => $request->precio]
            );
        }

        // Redirigir al listado de ventas con mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada con éxito');
    }

    /**
     * Remove the specified venta from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        // Eliminar los detalles de la venta
        $venta->detalles()->delete();

        // Eliminar la venta
        $venta->delete();

        // Redirigir al listado de ventas con mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada con éxito');
    }
}
