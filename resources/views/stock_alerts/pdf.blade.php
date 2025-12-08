<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Alertas de Stock</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #000;
            padding: 20px;
        }

        /* Header */
        .header {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo {
            width: 80px;
            vertical-align: middle;
        }

        .header-logo img {
            width: 70px;
            height: 70px;
        }

        .header-content {
            vertical-align: middle;
            padding-left: 15px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 14px;
            color: #444;
            font-weight: normal;
        }

        .report-date {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        /* Tabla de datos */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .data-table th {
            background-color: #1f2937;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .data-table td {
            border-bottom: 1px solid #dee2e6;
            padding: 8px 6px;
            font-size: 9px;
            color: #000;
        }

        .data-table .text-right {
            text-align: right;
        }

        .data-table .text-center {
            text-align: center;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #444;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
            background-color: #f8f9fa;
            border: 1px dashed #dee2e6;
        }
    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo EBC">
                    @endif
                </td>
                <td class="header-content">
                    <div class="company-name">EBC - Elise Beauty Center</div>
                    <div class="report-title">REPORTE DE ALERTAS DE STOCK</div>
                    <div class="report-date">Generado el {{ now()->format('d/m/Y H:i:s') }}</div>
                </td>
            </tr>
        </table>
    </div>

    @if($lowStockProducts->count() > 0)
        <div style="margin-bottom: 15px;">
            <strong>Total de productos con stock bajo:</strong> {{ $totalProducts }}
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 15%;">SKU</th>
                    <th style="width: 35%;">Producto</th>
                    <th style="width: 20%;">Categoría</th>
                    <th style="width: 15%;" class="text-center">Stock Actual</th>
                    <th style="width: 15%;" class="text-center">Stock Mínimo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                        <td class="text-center" style="color: red; font-weight: bold;">{{ $product->current_stock }}</td>
                        <td class="text-center">{{ $product->min_stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>No hay productos con stock bajo en este momento.</p>
        </div>
    @endif

    <div class="footer">
        <p>Reporte generado automáticamente por el sistema.</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>
