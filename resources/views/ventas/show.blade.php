@extends('template')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalle de Venta</h1>

    <!-- Información de la Venta -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Información de la Venta</h4>
        </div>
        <div class="card-body">
            <p><strong>ID de Venta:</strong> {{ $venta->id }}</p>
            <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>
        </div>
    </div>

    <!-- Información del Cliente -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Información del Cliente</h4>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $venta->cliente->nombre }}</p>
            <p><strong>Email:</strong> {{ $venta->cliente->email }}</p>
            <p><strong>Teléfono:</strong> {{ $venta->cliente->telefono }}</p>
        </div>
    </div>

    <!-- Información del Usuario -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Información del Usuario</h4>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $venta->user->name }}</p>
            <p><strong>Email:</strong> {{ $venta->user->email }}</p>
        </div>
    </div>

    <!-- Información de la Sucursal -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Información de la Sucursal</h4>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $venta->sucursal->nombre }}</p>
            <p><strong>Dirección:</strong> {{ $venta->sucursal->direccion }}</p>
        </div>
    </div>

    <!-- Detalle de Productos -->
    <div class="card">
        <div class="card-header">
            <h4>Detalle de Productos</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalleVentas as $detalle)
                        @php
                            $producto = $detalle->producto();
                        @endphp
                        <tr>
                            <td>
                                {{ $producto ? ($detalle->tipo_producto === 'medicamento' ? 'Medicamento - ' : 'Equipo Médico - ') . $producto->nombre : 'Producto no encontrado' }}
                            </td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>${{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Botón para regresar -->
    <div class="mt-4">
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver a la lista de ventas</a>
    </div>
</div>
@endsection
