<?php

namespace App\Http\Controllers;

use App\Models\Proveedore;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class ProveedoreController extends Controller
{
    public function index()
    {
        $proveedores = Proveedore::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function show(Proveedore $proveedore)
    {
        return view('proveedores.show', compact('proveedore'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:9',
            'direccion' => 'nullable|string|max:255',
        ]);

        Proveedore::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado con éxito');
    }

    public function edit(Proveedore $proveedore)
    {
        return view('proveedores.edit', compact('proveedore'));
    }

    public function update(Request $request, Proveedore $proveedore)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:9',
            'direccion' => 'nullable|string|max:255',
        ]);

        $proveedore->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado con éxito');
    }

    public function destroy(Proveedore $proveedore)
    {
        $proveedore->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado con éxito');
    }
        public function generarReporte()
    {
        $proveedores = Proveedore::with(['medicamentos', 'equiposMedicos'])->get();
        $pdf = Pdf::loadView('proveedores.reporte', compact('proveedores'));
        return $pdf->download('reporte_proveedores_productos.pdf');
    }
}
