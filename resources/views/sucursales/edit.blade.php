@extends('template')

@section('title', 'Editar Sucursal')

@push('css')
    <!-- Estilos adicionales si es necesario -->
@endpush

@section('content')
<div class="container">
    <!-- Título de la Página -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">EDITAR SUCURSAL</h1>
    </div>

    <!-- Formulario de Edición de Sucursal -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario de edición para sucursal</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sucursales.update', $sucursale->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Indicamos que se utilizará el método PUT para la actualización -->

                <!-- Campo: Nombre -->
                <div class="form-group">
                    <label for="nombre" class="font-weight-bold">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $sucursale->nombre) }}" placeholder="Ingrese el nombre de la sucursal" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Dirección -->
                <div class="form-group">
                    <label for="direccion" class="font-weight-bold">Dirección</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $sucursale->direccion) }}" placeholder="Ingrese la dirección de la sucursal" required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Teléfono -->
                <div class="form-group">
                    <label for="telefono" class="font-weight-bold">Teléfono</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $sucursale->telefono) }}" placeholder="Ingrese el teléfono de la sucursal">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de Enviar -->
                <button type="submit" class="btn btn-primary btn-block">ACTUALIZAR SUCURSAL</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
    <!-- Scripts adicionales si es necesario -->
@endpush
