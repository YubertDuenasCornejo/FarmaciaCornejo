@extends('template')

@section('title', 'Lista de Proveedores')

@push('css')
    <!-- Puedes agregar estilos adicionales si es necesario -->
@endpush

@section('content')
<div class="container-fluid">
@if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
    <!-- Título de la Página -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">GESTIÓN DE PROVEEDORES</h1>
 </div>   
        <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('proveedores.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus fa-sm text-white-50"></i> Añadir Nuevo Proveedor
        </a>
        
        <a href="{{ route('proveedores.reporte') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte
        </a>
    </div>

    <!-- Tabla de Proveedores -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Proveedores</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Productos Suministrados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->email }}</td>
                            <td>{{ $proveedor->telefono ?? 'No especificado' }}</td>
                            <td>{{ $proveedor->direccion ?? 'No especificada' }}</td>
                            <td>
                                <!-- Lista de productos suministrados -->
                                @if($proveedor->medicamentos->isNotEmpty() || $proveedor->equiposMedicos->isNotEmpty())
                                    <ul>
                                        @foreach($proveedor->medicamentos as $medicamento)
                                            <li>{{ $medicamento->nombre }} (Medicamento)</li>
                                        @endforeach
                                        @foreach($proveedor->equiposMedicos as $equipo)
                                            <li>{{ $equipo->nombre }} (Equipo Médico)</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>No hay productos asociados</span>
                                @endif
                            </td>
                            <td>
                                <!-- Botones de acción -->
                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
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
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
