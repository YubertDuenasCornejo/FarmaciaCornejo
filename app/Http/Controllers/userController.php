<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Persona;
use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;

class userController extends Controller
{
    public function __construct()
    {   
        /*$this->middleware('can:ver-usuario')->only('index');
        $this->middleware('can:crear-usuario')->only('create', 'store');
        $this->middleware('can:editar-usuario')->only('edit', 'update');
        $this->middleware('can:eliminar-usuario')->only('destroy');*/   
    }
    /* public function search(Request $request)
     {
         $nombre = $request->input('nombre');
         $persona = Persona::where('nombres', 'LIKE', "%$nombre%")->first();  // Busca la persona por nombre
     
         if ($persona) {
             return response()->json([
                 'id' => $persona->id,
                 'nombres' => $persona->nombres,
                 'apellidos' => $persona->apellidos,
                 'dni' => $persona->dni,
                 'direccion' => $persona->direccion,
                 'telefono' => $persona->telefono,
             ]);
         } else {
             return response()->json(null);
         }
     }*/
      
    public function index()
    {
        $users = User::all();
        return view('user.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        //$areas = Area::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
       

        $fieldHash = Hash::make($request->password);
        $request->merge(['password' => $fieldHash]);
        try{
            //creando usuario
            DB::beginTransaction();
            //Encriptar contraseña
           //dd($request);
            $user = User::create([
                'name' => $request->validated()['nombre'],
                'email' => $request->validated()['email'],
                'password' => $request->validated()['password'],

            ]);

           /* $persona = Persona::create([
                'nombres' => $request->validated()['nombre'],
                'apellidos' => $request->validated()['apellido'],
                'dni' => $request->validated()['dni'],
                'direccion' => $request->validated()['direccion'],
                'telefono' => $request->validated()['telefono'],
                'id_area' => $request->validated()['area'],
                'id_user' => $user->id,

            ]);*/
            $user->assignRole($request->role); // ->ahorita te hago funcionar

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('users.index')->with('success','Usuario creado correctamente');
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
    public function edit(User $user)
    {
        $roles = Role::all();
        //$areas = Area::all(); // Obtener todas las áreas
        //dd($trabajadore);
        return view('user.edit', ['user' => $user,'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //dd($user);
        $user->name = $request->validated()['nombre'];
        $user->email = $request->validated()['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated()['password']);
        }
        $user->save();
        $user->syncRoles([$request->role]);

        /*$persona->nombres = $request->validated()['nombre'];
        $persona->apellidos = $request->validated()['apellido'];
        $persona->dni = $request->validated()['dni'];
        $persona->direccion = $request->validated()['direccion'];
        $persona->telefono = $request->validated()['telefono'];
        $persona->id_area = $request->validated()['area'];
        $persona->save();
*/
        
        
        return redirect()->route('users.index')->with('success', 'Usuario editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // //$area = Area::find($id);
        $user = User::find($id);
        //$persona = Persona::find($id);
        //$persona->user()->delete(); // Eliminar el usuario asociado
        //$persona->delete(); // Eliminar el trabajador
        $user->delete();
        //Eliminar rol
        $rolUser = $user->getRoleNames()->first();
        $user->removeRole($rolUser);

        return redirect()->route('userss.index')->with('success', 'Usuario eliminado correctamente');
    }
}
