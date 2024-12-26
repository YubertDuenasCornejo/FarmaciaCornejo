<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Sucursal;
use App\Models\Proveedore;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function index()
    {
        // Ventas totales del mes actual
        $monthlySalesChart = new LaravelChart([
            'chart_title' => 'Ventas Totales (Mensuales)',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Venta',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_days' => 30, // Últimos 30 días
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total',
        ]);

        // Ventas totales anuales
        $annualSalesChart = new LaravelChart([
            'chart_title' => 'Ventas Totales (Anuales)',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Venta',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_days' => 365, // Últimos 365 días
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total',
        ]);

        // Sucursal con más ventas
        $topSucursalChart = new LaravelChart([
            'chart_title' => 'Sucursal con Más Ventas',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Venta',
            'group_by_field' => 'nombre',
            'relationship_name' => 'sucursal',
            'chart_type' => 'pie',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total',
        ]);

         // Proveedores con más medicamentos
    $topProvidersMedicamentosChart = new LaravelChart([
        'chart_title' => 'Proveedores con Más Medicamentos',
        'report_type' => 'group_by_relationship',
        'model' => 'App\Models\Medicamento',
        'group_by_field' => 'nombre',
        'relationship_name' => 'proveedore',
        'chart_type' => 'bar',
        'aggregate_function' => 'count',
    ]);

    // Proveedores con más equipos médicos
    $topProvidersEquiposMedicosChart = new LaravelChart([
        'chart_title' => 'Proveedores con Más Equipos Médicos',
        'report_type' => 'group_by_relationship',
        'model' => 'App\Models\EquipoMedico',
        'group_by_field' => 'nombre',
        'relationship_name' => 'proveedore',
        'chart_type' => 'bar',
        'aggregate_function' => 'count',
    ]);

    return view('panel.index', compact(
        'monthlySalesChart',
        'annualSalesChart',
        'topSucursalChart',
        'topProvidersMedicamentosChart',
        'topProvidersEquiposMedicosChart'
    ));
    }
}
