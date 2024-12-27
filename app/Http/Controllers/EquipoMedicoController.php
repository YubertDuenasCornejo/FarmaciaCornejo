<?php

namespace App\Http\Controllers;

use App\Models\EquipoMedico;
use App\Models\Proveedore;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipoMedicoController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:gestionar-productos')->only('index','create','store','edit','update','destroy','show'); 
    }
    public function index()
    {
        $equiposMedicos = EquipoMedico::all();
        return view('equipoMedico.index', compact('equiposMedicos'));
    }

    public function show(EquipoMedico $equipoMedico)
    {
        return view('equipoMedico.show', compact('equipoMedico'));
    }

    public function create()
    {
        $proveedores = Proveedore::all();
        return view('equipoMedico.create', compact('proveedores'));
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

        EquipoMedico::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request ->input('descripcion'),
            'precio' => $request->input('precio'),
            'stock' => $request->input('stock'),
            'proveedore_id' => $request->input('proveedore_id'), // Asegúrate de incluir este campo
        ]);

        return redirect()->route('equipoMedico.index')->with('success', 'Equipo médico creado con éxito');
    }

    public function edit(EquipoMedico $equipoMedico)
    {
        $proveedores = Proveedore::all();
        return view('equipoMedico.edit', compact('equipoMedico', 'proveedores'));
    }

    public function update(Request $request, EquipoMedico $equipoMedico)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedore_id' => 'nullable|exists:proveedores,id',
        ]);

        $equipoMedico->update($request->all());

        return redirect()->route('equipoMedico.index')->with('success', 'Equipo médico actualizado con éxito');
    }

    public function destroy(EquipoMedico $equipoMedico)
    {
        $equipoMedico->delete();
        return redirect()->route('equipoMedico.index')->with('success', 'Equipo médico eliminado con éxito');
    }
        public function generarReporte()
    {
        $equiposMedicos = EquipoMedico::all();
        $pdf = Pdf::loadView('equipoMedico.reporte', compact('equiposMedicos'));
        return $pdf->download('reporte_equipos_medicos.pdf');
    }

}