@extends('template')
@section('title', 'Actualizar Roles')
@push('css')
    
@endpush

@section('content')
    <h1 class="mt-4 text-center">Actualizar Roles</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
        <li class="breadcrumb-item" active>Actualizar Rol</li>
    </ol>
    <div class="card">
        <div class="card-header">
            <p>Nota: Los roles son un conjunto de permisos</p>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update',['role'=>$role]) }}" method="post">
                @method('PATCH')
                @csrf
                <!---Nombre de rol---->
                <div class="row mb-4">
                    <label for="name" class="col-md-auto col-form-label">Nombre del rol:</label>
                    <div class="col-md-4">
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name',$role->name)}}">
                    </div>
                    <div class="col-md-4">
                        @error('name')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Permisos---->
                <div class="col-12">
                    <p class="text-muted">Permisos para el rol:</p>
                    @foreach ($permisos as $item)
                    @if ( in_array($item->id, $role->permissions->pluck('id')->toArray() ) )
                    <div class="form-check mb-2">
                        <input checked type="checkbox" name="permission[]" id="{{$item->id}}" class="form-check-input" value="{{$item->name}}">
                        <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                    </div>
                    @else
                    <div class="form-check mb-2">
                        <input type="checkbox" name="permission[]" id="{{$item->id}}" class="form-check-input" value="{{$item->name}}">
                        <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                    </div>
                    @endif
                    @endforeach
                </div>
                @error('permission')
                <small class="text-danger">{{'*'.$message}}</small>
                @enderror


                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="reset" class="btn btn-secondary">Reiniciar</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('js')
    
@endpush