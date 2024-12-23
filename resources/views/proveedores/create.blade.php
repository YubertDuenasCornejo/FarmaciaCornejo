@extends('template')

@section('title', 'Crear Proveedor')

@push('css')
    <!-- Agrega estilos adicionales si es necesario -->
@endpush

@section('content')
<div class="container w-50 border border-3 border-primary rounded p-4 mt-3">
    <!-- Título de la Página -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">REGISTRO DE PROVEEDOR</h1>
    </div>

    <!-- Formulario de Creación de Proveedor -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario de registro para nuevo proveedor</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('proveedores.store') }}" method="POST">
                @csrf <!-- Token CSRF para protección -->

                <!-- Campo: Nombre -->
                <div class="form-group">
                    <label for="nombre" class="font-weight-bold">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre del proveedor" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Email -->
                <div class="form-group">
                    <label for="email" class="font-weight-bold">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Ingrese el email del proveedor" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Teléfono -->
                <div class="form-group">
                    <label for="telefono" class="font-weight-bold">Teléfono</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Ingrese el teléfono del proveedor (opcional)">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Dirección -->
                <div class="form-group">
                    <label for="direccion" class="font-weight-bold">Dirección</label>
                    <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3" placeholder="Ingrese la dirección del proveedor (opcional)">{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de Enviar -->
                <button type="submit" class="btn btn-primary btn-block">REGISTRAR PROVEEDOR</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <!-- Agrega scripts adicionales si es necesario -->
@endpush
