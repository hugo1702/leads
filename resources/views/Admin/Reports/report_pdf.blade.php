<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Leads</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #1f2937; /* text-gray-800 */
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: #111827; /* text-gray-900 */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #f3f4f6; /* bg-gray-100 */
            font-weight: 600;
            font-size: 13px;
            padding: 10px;
            text-align: left;
            border: 1px solid #d1d5db; /* border-gray-300 */
        }

        td {
            font-size: 12px;
            padding: 10px;
            border: 1px solid #e5e7eb; /* border-gray-200 */
        }

        tr:nth-child(even) {
            background-color: #f9fafb; /* bg-gray-50 */
        }

        tr:hover {
            background-color: #f3f4f6; /* bg-gray-100 */
        }
    </style>
</head>
<body>
    <h1>Reporte de Leads por Operador</h1>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Total Leads</th>
                <th>Abiertos</th>
                <th>Cerrados</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($operadoresConStats as $op)
                <tr>
                    <td>{{ $op['nombre'] }}</td>
                    <td>{{ $op['correo'] }}</td>
                    <td>{{ $op['total'] }}</td>
                    <td>{{ $op['abiertos'] }}</td>
                    <td>{{ $op['cerrados'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
