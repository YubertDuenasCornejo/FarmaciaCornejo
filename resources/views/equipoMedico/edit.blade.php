@extends('template')

@section('title', 'Editar Equipo Médico')

@push('css')
    <!-- Puedes agregar estilos adicionales si es necesario -->
@endpush

@section('content')
<div class="container w-50 border border-3 border-primary rounded p-4 mt-3">
    <!-- Título de la Página -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">EDITAR EQUIPO MÉDICO</h1>
    </div>

    <!-- Formulario de Edición de Equipo Médico -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario de edición para el equipo médico seleccionado</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('equipoMedico.update', $equipoMedico->id) }}" method="POST">
                @csrf <!-- Token CSRF para protección -->
                @method('PUT') <!-- Método HTTP para actualizar -->

                <!-- Campo: Nombre -->
                <div class="form-group">
                    <label for="nombre" class="font-weight-bold">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $equipoMedico->nombre) }}" placeholder="Ingrese el nombre del equipo médico" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Descripción -->
                <div class="form-group">
                    <label for="descripcion" class="font-weight-bold">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" placeholder="Ingrese una descripción del equipo médico">{{ old('descripcion', $equipoMedico->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Precio -->
                <div class="form-group">
                    <label for="precio" class="font-weight-bold">Precio</label>
                    <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" value="{{ old('precio', $equipoMedico->precio) }}" placeholder="Ingrese el precio del equipo médico" required>
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Stock -->
                <div class="form-group">
                    <label for="stock" class="font-weight-bold">Stock</label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $equipoMedico->stock) }}" placeholder="Ingrese el stock del equipo médico" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo: Proveedor -->
                <div class="form-group">
                    <label for="proveedore_id" class="font-weight-bold">Proveedor</label>
                    <select class="form-control @error('proveedore_id') is-invalid @enderror" id="proveedore_id" name="proveedore_id" required>
                        <option value="">Selecciona un proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ old('proveedore_id', $equipoMedico->proveedore_id) == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('proveedore_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de Enviar -->
                <button type="submit" class="btn btn-primary btn-block">ACTUALIZAR EQUIPO MÉDICO</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
