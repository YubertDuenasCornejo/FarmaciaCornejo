<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class SucursalController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:administrar-sucursales')->only('index','create','store','edit','update','destroy','show'); 
    }
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('sucursales.index', compact('sucursales'));
    }

    public function show(Sucursal $sucursal)
    {
        return view('sucursales.show', compact('sucursal'));
    }

    public function create()
    {
        return view('sucursales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:9',
        ]);

        Sucursal::create($request->all());

        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada con éxito');
    }

    public function edit(Sucursal $sucursale)
    {
       
        return view('sucursales.edit', compact('sucursale'));
    }

    public function update(Request $request, Sucursal $sucursale)
    {
     

        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:9',
        ]);
        $sucursale      ->update($request->all());

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada con éxito');
    }

    public function destroy(Sucursal $sucursale)
    {
        $sucursale->delete();
        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada con éxito');
    }
}
