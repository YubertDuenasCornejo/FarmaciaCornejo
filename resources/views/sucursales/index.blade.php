@extends('template')

@section('title', 'Gestionar Sucursales')

@push('css')
    <!-- Agrega estilos adicionales si es necesario -->
@endpush

@section('content')
<div class="container">
    <!-- Título de la Página -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">GESTIÓN DE SUCURSALES</h1>
        <a href="{{ route('sucursales.create') }}" class="btn btn-primary btn-sm">Nueva Sucursal</a>
    </div>

    <!-- Tabla de Sucursales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Sucursales</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sucursales as $sucursal)
                            <tr>
                                <td>{{ $sucursal->nombre }}</td>
                                <td>{{ $sucursal->direccion }}</td>
                                <td>{{ $sucursal->telefono }}</td>
                                <td>
                                    <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('sucursales.destroy', $sucursal->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar esta sucursal?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <!-- Puedes agregar scripts para la tabla, como los de DataTables si lo necesitas -->
@endpush
