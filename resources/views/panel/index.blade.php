@extends ('template')

@section('title','Panel')
@push('css')
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Panel de Control</h1>

    <!-- Gráficos -->
    <div class="row">
        <div class="col-md-6">
            <h5>Ventas Totales (Mensuales)</h5>
            {!! $monthlySalesChart->renderHtml() !!}
        </div>
        <div class="col-md-6">
            <h5>Ventas Totales (Anuales)</h5>
            {!! $annualSalesChart->renderHtml() !!}
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Sucursal con Más Ventas</h5>
            {!! $topSucursalChart->renderHtml() !!}
        </div>
        <div class="row">
                 <!-- Proveedores con más medicamentos -->
            <div class="col-xl-6">
                {!! $topProvidersMedicamentosChart->renderHtml() !!}
            </div>

             <!-- Proveedores con más equipos médicos -->
            <div class="col-xl-6">
                {!! $topProvidersEquiposMedicosChart->renderHtml() !!}
            </div>
        </div>
    </div>
</div>
@endsection
</div>


@push('js')
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{!! $monthlySalesChart->renderJs() !!}
{!! $annualSalesChart->renderJs() !!}
{!! $topSucursalChart->renderJs() !!}
{!! $topProvidersMedicamentosChart->renderChartJsLibrary() !!}
{!! $topProvidersMedicamentosChart->renderJs() !!}
{!! $topProvidersEquiposMedicosChart->renderJs() !!}
@endpush