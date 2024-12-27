<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Proveedore;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::all();
        return view('medicamentos.index', compact('medicamentos'));
    }

    public function show(Medicamento $medicamento)
    {
        return view('medicamentos.show', compact('medicamento'));
    }

    public function create()
    {
        $proveedores = Proveedore::all();
        return view('medicamentos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'proveedore_id' => 'required|exists:proveedores,id',
        ]);

        Medicamento::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request ->input('descripcion'),
            'precio' => $request->input('precio'),
            'stock' => $request->input('stock'),
            'proveedore_id' => $request->input('proveedore_id'), // Asegúrate de incluir este campo
        ]);
        return redirect()->route('medicamentos.index')->with('success', 'Medicamento creado con éxito');
    }

    public function edit(Medicamento $medicamento)
    {
        $proveedores = Proveedore::all();
        return view('medicamentos.edit', compact('medicamento', 'proveedores'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedore_id' => 'nullable|exists:proveedores,id',
        ]);

        $medicamento->update($request->all());

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento actualizado con éxito');
    }

    public function destroy(Medicamento $medicamento)
    {
        $medicamento->delete();
        return redirect()->route('medicamentos.index')->with('success', 'Medicamento eliminado con éxito');
    }
        public function generarReporte()
    {
        $medicamentos = Medicamento::all();
        $pdf = Pdf::loadView('medicamentos.reporte', compact('medicamentos'));
        return $pdf->download('reporte_medicamentos.pdf');
    }
}

