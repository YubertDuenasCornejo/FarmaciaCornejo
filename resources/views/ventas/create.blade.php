@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Registrar Venta</h1>
    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="" disabled selected>Seleccione un usuario</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="sucursal_id" class="form-label">Sucursal</label>
            <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                <option value="" disabled selected>Seleccione una sucursal</option>
                @foreach ($sucursals as $sucursal)
                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="productos" class="form-label">Productos</label>
            <div id="productos-container">
                <!-- Aquí se agregarán los productos dinámicamente -->
            </div>
            <button type="button" class="btn btn-secondary mt-2" id="add-product">Agregar Producto</button>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>
</div>

<script>
    const productosContainer = document.getElementById('productos-container');
    const addProductButton = document.getElementById('add-product');

    addProductButton.addEventListener('click', () => {
        const productTemplate = `
            <div class="producto-item mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="productos[][tipo_producto]" class="form-control" required>
                            <option value="" disabled selected>Tipo de Producto</option>
                            <option value="medicamento">Medicamento</option>
                            <option value="equipo_medico">Equipo Médico</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="productos[][id]" class="form-control" placeholder="ID del Producto" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="productos[][cantidad]" class="form-control" placeholder="Cantidad" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-product">Eliminar</button>
                    </div>
                </div>
            </div>
        `;
        productosContainer.insertAdjacentHTML('beforeend', productTemplate);
    });

    productosContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('.producto-item').remove();
        }
    });
</script>
@endsection
