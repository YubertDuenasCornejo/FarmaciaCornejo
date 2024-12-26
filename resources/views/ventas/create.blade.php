@extends('template')

@section('content')
<div class="container">
    <h1 class="mb-4">Nueva Venta</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <!-- Selección del Usuario -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Seleccione un usuario</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Selección de la Sucursal -->
        <div class="mb-3">
            <label for="sucursal_id" class="form-label">Sucursal</label>
            <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                <option value="">Seleccione una sucursal</option>
                @foreach ($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Detalle de Productos -->
        <div id="productos-container" class="mb-3">
            <h4>Productos</h4>
            <div class="producto-item">
                <div class="row">
                    <div class="col-md-4">
                        <label for="producto_id_1" class="form-label">Producto</label>
                        <select name="productos[0][producto_id]" id="producto_id_1" class="form-control" required>
                            <option value="">Seleccione un producto</option>
                            @foreach ($medicamentos as $medicamento)
                                <option value="{{ $medicamento->id }}">
                                    Medicamento - {{ $medicamento->nombre }}
                                </option>
                            @endforeach
                            @foreach ($equipos as $equipo)
                                <option value="{{ $equipo->id }}">
                                    Equipo Médico - {{ $equipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="cantidad_1" class="form-label">Cantidad a vender</label>
                        <input type="number" name="productos[0][cantidad]" id="cantidad_1" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label for="precio_unitario_1" class="form-label">Precio Unitario</label>
                        <input type="number" name="productos[0][precio_unitario]" id="precio_unitario_1" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger w-100 remove-producto">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="add-producto">Añadir Producto</button>

        <!-- Total -->
        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" name="total" id="total" class="form-control" step="0.01" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar Venta</button>
    </form>
</div>

<script>
    // Script para añadir y eliminar productos dinámicamente
    document.getElementById('add-producto').addEventListener('click', () => {
        const container = document.getElementById('productos-container');
        const index = container.querySelectorAll('.producto-item').length;

        const newProducto = `
            <div class="producto-item">
                <div class="row">
                    <div class="col-md-4">
                        <label for="producto_id_${index}" class="form-label">Producto</label>
                        <select name="productos[${index}][producto_id]" id="producto_id_${index}" class="form-control" required>
                            <option value="">Seleccione un producto</option>
                            @foreach ($medicamentos as $medicamento)
                                <option value="{{ $medicamento->id }}">
                                    Medicamento - {{ $medicamento->nombre }}
                                </option>
                            @endforeach
                            @foreach ($equipos as $equipo)
                                <option value="{{ $equipo->id }}">
                                    Equipo Médico - {{ $equipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="cantidad_${index}" class="form-label">Cantidad</label>
                        <input type="number" name="productos[${index}][cantidad]" id="cantidad_${index}" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label for="precio_unitario_${index}" class="form-label">Precio Unitario</label>
                        <input type="number" name="productos[${index}][precio_unitario]" id="precio_unitario_${index}" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger w-100 remove-producto">Eliminar</button>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', newProducto);
    });

    document.getElementById('productos-container').addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-producto')) {
            e.target.closest('.producto-item').remove();
        }
    });
</script>
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