<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Equipos Médicos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte de Equipos Médicos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Proveedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equiposMedicos as $equipoMedico)
                <tr>
                    <td>{{ $equipoMedico->id }}</td>
                    <td>{{ $equipoMedico->nombre }}</td>
                    <td>{{ $equipoMedico->descripcion }}</td>
                    <td>{{ $equipoMedico->precio }}</td>
                    <td>{{ $equipoMedico->stock }}</td>
                    <td>{{ $equipoMedico->proveedore->nombre ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
