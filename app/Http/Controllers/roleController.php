<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;
class roleController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:ver-roles')->only('index');
        $this->middleware('can:crear-roles')->only('create', 'store');
        $this->middleware('can:editar-roles')->only('edit', 'update');
        $this->middleware('can:eliminar-roles')->only('destroy');  
    }
    public function index()
    {
        $roles = Role::all();
        return view('role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('role.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ]);

        try {
            DB::beginTransaction();
            //Crear rol
            $rol = Role::create(['name' => $request->name]);

            //Asignar permisos
            $rol->syncPermissions($request->permission);

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }


        return redirect()->route('roles.index')->with('success', 'Rol registrado');
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
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permisos = Permission::all();
        return view('role.edit', compact('role', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required'
        ]);

        try {
            DB::beginTransaction();

            //Actualizar rol
            Role::where('id', $role->id)
                ->update([
                    'name' => $request->name
                ]);

            //Actualizar permisos
            $role->syncPermissions($request->permission);

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }

        return redirect()->route('roles.index')->with('success', 'rol editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'rol eliminado');
    }
}
