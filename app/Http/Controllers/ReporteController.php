<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MedicamentosExport;

class ReporteController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new MedicamentosExport, 'medicamentos.xlsx');
    }
}
