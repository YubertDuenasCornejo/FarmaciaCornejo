@extends ('template')

@section('title','Panel')

@push('css')
<!-- FontAwesome y Google Fonts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-center">Panel de Control</h1>

    <!-- Gráficos -->
    <div class="row">
        <!-- Ventas Totales Mensuales -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5>Ventas Totales (Mensuales)</h5>
                </div>
                <div class="card-body">
                    {!! $monthlySalesChart->renderHtml() !!}
                </div>
            </div>
        </div>

        <!-- Ventas Totales Anuales -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white text-center">
                    <h5>Ventas Totales (Anuales)</h5>
                </div>
                <div class="card-body">
                    {!! $annualSalesChart->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sucursal con Más Ventas -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-info text-white text-center">
                    <h5>Sucursal con Más Ventas</h5>
                </div>
                <div class="card-body">
                    {!! $topSucursalChart->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Proveedores Medicamentos y Equipos Médicos -->
    <div class="row">
        <!-- Proveedores con Más Medicamentos -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark text-center">
                    <h5>Proveedores con Más Medicamentos</h5>
                </div>
                <div class="card-body">
                    {!! $topProvidersMedicamentosChart->renderHtml() !!}
                </div>
            </div>
        </div>

        <!-- Proveedores con Más Equipos Médicos -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h5>Proveedores con Más Equipos Médicos</h5>
                </div>
                <div class="card-body">
                    {!! $topProvidersEquiposMedicosChart->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{!! $monthlySalesChart->renderJs() !!}
{!! $annualSalesChart->renderJs() !!}
{!! $topSucursalChart->renderJs() !!}
{!! $topProvidersMedicamentosChart->renderJs() !!}
{!! $topProvidersEquiposMedicosChart->renderJs() !!}
@endpush
