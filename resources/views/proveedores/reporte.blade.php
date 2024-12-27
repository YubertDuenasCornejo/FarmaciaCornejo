<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Proveedores con Productos</title>
    <style>
        /* Fuente y base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background-color: #f7f9fc;
            color: #333;
        }

        /* Encabezado principal */
        h1 {
            font-size: 28px;
            color: #004d7f;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #004d7f;
            padding-bottom: 10px;
            font-weight: 600;
        }

        /* Títulos de secciones */
        h2 {
            font-size: 22px;
            color: #004d7f;
            margin-top: 20px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        h3 {
            font-size: 18px;
            color: #004d7f;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        /* Estilo de tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            text-align: left;
            font-size: 15px;
        }

        table th {
            background-color: #004d7f;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td {
            background-color: #fafafa;
        }

        table tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        /* Sección de productos */
        .product-list {
            margin-left: 20px;
            margin-top: 10px;
        }

        .product-list ul {
            padding-left: 20px;
            list-style-type: none;
            font-size: 16px;
        }

        .product-list ul li {
            padding: 8px;
            margin-bottom: 5px;
            border-left: 4px solid #004d7f;
            background-color: #f8f8f8;
            border-radius: 4px;
        }

        .product-list ul li:hover {
            background-color: #e7f0fa;
            cursor: pointer;
        }

        /* Mensajes de "no hay datos" */
        .no-data {
            color: #777;
            font-style: italic;
            margin-top: 10px;
        }

        /* Separadores y márgenes */
        .section {
            margin-bottom: 40px;
        }

        .section hr {
            border: 0;
            border-top: 2px solid #e0e0e0;
            margin-top: 40px;
        }

        /* Estilo para las secciones */
        .section-heading {
            font-size: 18px;
            color: #004d7f;
            font-weight: 600;
        }
        
    </style>
</head>
<body>
    <h1>Reporte de Proveedores y Productos Suministrados</h1>

    @foreach ($proveedores as $proveedor)
        <div class="section">
            <h2>Proveedor: {{ $proveedor->nombre }}</h2>
            <table>
                <tr>
                    <th>Email</th>
                    <td>{{ $proveedor->email }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $proveedor->telefono }}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{ $proveedor->direccion }}</td>
                </tr>
            </table>

            <h3 class="section-heading">Medicamentos Suministrados</h3>
            @if ($proveedor->medicamentos->isEmpty())
                <p class="no-data">No hay medicamentos suministrados por este proveedor.</p>
            @else
                <div class="product-list">
                    <ul>
                        @foreach ($proveedor->medicamentos as $medicamento)
                            <li>{{ $medicamento->nombre }} - {{ $medicamento->descripcion }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 class="section-heading">Equipos Médicos Suministrados</h3>
            @if ($proveedor->equiposMedicos->isEmpty())
                <p class="no-data">No hay equipos médicos suministrados por este proveedor.</p>
            @else
                <div class="product-list">
                    <ul>
                        @foreach ($proveedor->equiposMedicos as $equipoMedico)
                            <li>{{ $equipoMedico->nombre }} - {{ $equipoMedico->descripcion }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <hr>
    @endforeach
</body>
</html>
