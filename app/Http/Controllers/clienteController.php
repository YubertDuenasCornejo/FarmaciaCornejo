<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;

class clienteController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:ver-clientes')->only('index');
        $this->middleware('can:crear-clientes')->only('create', 'store');
        $this->middleware('can:editar-clientes')->only('edit', 'update');
        $this->middleware('can:eliminar-clientes')->only('destroy');  
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('cliente.index',['clientes'=>$clientes]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        try{
            DB::beginTransaction();
            $cliente = Cliente::create([
                'nombre' => $request->validated()['nombre'],
                'dni' => $request->validated()['dni'],
                'telefono' => $request->validated()['telefono'],
                'direccion' => $request->validated()['direccion'],

            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('clientes.index')->with('success','Registro agregado Correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('cliente.edit',['cliente'=>$cliente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        Cliente::where('id',$cliente->id)->update($request->validated());
        return redirect()->route('clientes.index')->with('success', 'Registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);
        Cliente::where('id',$cliente->id)->delete();
        return redirect()->route('clientes.index')->with('success','Registro Eliminado Correctamente');
    }
}
