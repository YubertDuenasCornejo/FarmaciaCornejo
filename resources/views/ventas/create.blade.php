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

        <!-- Selección del Cliente -->
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control" required>
                <option value="">Seleccione un cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
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

        <!-- Tabla de Detalle de Productos -->
        <div class="mb-3">
            <h4>Detalle de Productos</h4>
            <table class="table table-bordered" id="detalle-productos">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas se agregarán dinámicamente aquí -->
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">
                Añadir Producto
            </button>
        </div>

        <!-- Campo oculto para enviar productos -->
        <input type="hidden" name="productos" id="productos">

        <!-- Total -->
        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" name="total" id="total" class="form-control" step="0.01" min="0" readonly>
        </div>

        <button type="submit" class="btn btn-success">Guardar Venta</button>
    </form>
</div>

<div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarProductoLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-agregar-producto">
                    <div class="mb-3">
                        <label for="producto_id" class="form-label">Producto</label>
                        <select name="producto_id" id="producto_id" class="form-control" required>
                            <option value="">Seleccione un producto</option>
                            @foreach ($medicamentos as $medicamento)
                                <option value="M{{ $medicamento->id }}" 
                                        data-nombre="Medicamento - {{ $medicamento->nombre }}" 
                                        data-stock="{{ $medicamento->stock }}" 
                                        data-precio="{{ $medicamento->precio }}">
                                    Medicamento - {{ $medicamento->nombre }}
                                </option>
                            @endforeach
                            @foreach ($equipos as $equipo)
                                <option value="E{{ $equipo->id }}" 
                                        data-nombre="Equipo Médico - {{ $equipo->nombre }}" 
                                        data-stock="{{ $equipo->stock }}" 
                                        data-precio="{{ $equipo->precio }}">
                                    Equipo Médico - {{ $equipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stock_actual" class="form-label">Stock Actual</label>
                        <input type="number" id="stock_actual" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio_unitario" class="form-label">Precio Unitario</label>
                        <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" step="0.01" min="0" readonly>
                    </div>
                    <button type="button" class="btn btn-primary" id="btnAgregarProducto">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Actualizar stock, precio unitario y nombre al seleccionar un producto
    document.getElementById('producto_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');
        const precio = selectedOption.getAttribute('data-precio');
        const nombre = selectedOption.getAttribute('data-nombre');

        document.getElementById('stock_actual').value = stock || 0;
        document.getElementById('precio_unitario').value = precio || 0;
    });

    // Agregar producto a la tabla
    document.getElementById('btnAgregarProducto').addEventListener('click', () => {
        const producto = document.getElementById('producto_id');
        const cantidad = document.getElementById('cantidad').value;
        const precioUnitario = document.getElementById('precio_unitario').value;
        const stock = document.getElementById('stock_actual').value;
        const nombre = producto.options[producto.selectedIndex].getAttribute('data-nombre');

        if (producto.value && cantidad && precioUnitario) {
            if (parseInt(cantidad) > parseInt(stock)) {
                alert('La cantidad no puede ser mayor al stock disponible.');
                return;
            }

            const subtotal = (cantidad * precioUnitario).toFixed(2);
            const tabla = document.getElementById('detalle-productos').querySelector('tbody');
            const nuevaFila = `
                <tr>
                    <td>${nombre}</td>
                    <td>${cantidad}</td>
                    <td>${precioUnitario}</td>
                    <td>${subtotal}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btnEliminar">Eliminar</button>
                        <input type="hidden" name="producto_id[]" value="${producto.value}">
                    </td>
                </tr>
            `;
            tabla.insertAdjacentHTML('beforeend', nuevaFila);

            actualizarProductos();
            actualizarTotal();

            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarProducto'));
            modal.hide();

            // Resetear formulario
            document.getElementById('form-agregar-producto').reset();
            document.getElementById('stock_actual').value = '';
            document.getElementById('precio_unitario').value = '';
        }
    });

    // Eliminar producto
    document.getElementById('detalle-productos').addEventListener('click', (e) => {
        if (e.target.classList.contains('btnEliminar')) {
            e.target.closest('tr').remove();
            actualizarProductos();
            actualizarTotal();
        }
    });

    // Actualizar el campo oculto de productos
    function actualizarProductos() {
        const productos = [];
        document.querySelectorAll('#detalle-productos tbody tr').forEach(row => {
            const producto = {
                producto_id: row.querySelector('input[name="producto_id[]"]').value,
                cantidad: row.children[1].textContent.trim(),
                precio_unitario: row.children[2].textContent.trim(),
            };
            productos.push(producto);
        });

        document.getElementById('productos').value = JSON.stringify(productos);
    }

    // Actualizar total
    function actualizarTotal() {
        let total = 0;
        document.querySelectorAll('#detalle-productos tbody tr').forEach(row => {
            total += parseFloat(row.children[3].textContent);
        });
        document.getElementById('total').value = total.toFixed(2);
    }
</script>
@endsection
