@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalles de la Venta #{{ $venta->id }}</h1>
    <p><strong>Usuario:</strong> {{ $venta->user->name }}</p>
    <p><strong>Sucursal:</strong> {{ $venta->sucursal->nombre }}</p>
    <p><strong>Total:</strong> S/ {{ number_format($venta->total, 2) }}</p>
    <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>

    <h2 class="mt-4">Productos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalleVentas as $detalle)
                <tr>
                    <td>{{ $detalle->producto()->nombre }}</td>
                    <td>{{ ucfirst($detalle->tipo_producto) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>S/ {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
