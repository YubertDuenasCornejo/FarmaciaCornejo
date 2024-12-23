@extends('template')

@section('title','Medicamentos')

@push('css')
<!-- Puedes agregar tus estilos adicionales aquí si es necesario -->
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
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Medicamentos</h1>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between mb-4">
        <!-- Botón para añadir nuevo medicamento (izquierda) -->
 
        <a href="{{ route('medicamentos.create') }}" class="btn btn-sm btn-success">
        <i class="fas fa-plus fa-sm text-white-50"></i> Añadit Nuevo Medicamento
        </a>
        
        <!-- Botón para generar reporte (derecha) -->
        <a href="" class="btn btn-sm btn-primary">
             <i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte
        </a>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Medicamentos Registrados</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Proveedor</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicamentos as $medicamento)
                            <tr>
                                <td>{{ $medicamento->nombre }}</td>
                                <td>{{ $medicamento->descripcion }}</td>
                                <td>{{ number_format($medicamento->precio, 2) }}</td>
                                <td>{{ $medicamento->proveedore->nombre ?? 'N/A' }}</td>
                                <td>{{ number_format($medicamento->stock, 2) }}</td>
                                <td>
                                    <a href="{{ route('medicamentos.edit', $medicamento) }}" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i> Editar </a>
                                    <form action="{{ route('medicamentos.destroy', $medicamento) }}" method="POST" style="display:inline;">
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
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
<script>
        // Mostrar el Toast automáticamente al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl).show();
            });
        });
    </script>
@endpush