<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial de Ventas - {{ now()->format('d/m/Y') }}</title>
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

        /* Header con logo a la izquierda */
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

        /* Filtros */
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            color: #000;
        }

        /* Tabla de ventas */
        .sales-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .sales-table th {
            background-color: #1f2937;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .sales-table td {
            border-bottom: 1px solid #dee2e6;
            padding: 8px 6px;
            font-size: 9px;
            vertical-align: top;
            color: #000;
        }

        .sales-table .text-right {
            text-align: right;
        }

        .sales-table .text-center {
            text-align: center;
        }

        /* Badges */
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .status-completada { background-color: #d4edda; color: #155724; }
        .status-pendiente { background-color: #fff3cd; color: #856404; }
        .status-cancelada { background-color: #f8d7da; color: #721c24; }

        .payment-badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .payment-efectivo { background-color: #d4edda; color: #155724; }
        .payment-tarjeta { background-color: #cce5ff; color: #004085; }
        .payment-transferencia { background-color: #e2d4f0; color: #6f42c1; }
        .payment-mixto { background-color: #d1ecf1; color: #0c5460; }

        /* Resumen */
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            page-break-inside: avoid;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 5px;
        }

        .summary-label {
            font-weight: bold;
            width: 30%;
            color: #000;
        }

        .summary-value {
            font-weight: bold;
            color: #000;
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

    <!-- Header -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo">
                    @endif
                </td>
                <td class="header-content">
                    <div class="company-name">{{ $appSettings['app_name'] ?? 'EBC - Elise Beauty Center' }}</div>
                    <div class="report-title">HISTORIAL DE VENTAS</div>
                    <div class="report-date">Generado el {{ now()->format('d/m/Y H:i:s') }}</div>
                </td>
            </tr>
        </table>
    </div>

    @if($sales->count() > 0)
        <div class="filters">
            <strong>Filtros aplicados:</strong><br>
            @if(request('search'))
                Búsqueda: "{{ request('search') }}" |
            @endif
            @if(request('status'))
                Estado: {{ ucfirst(request('status')) }} |
            @endif
            Total de registros: {{ $sales->count() }}
        </div>

        <table class="sales-table">
            <thead>
                <tr>
                    <th style="width: 12%;">Folio</th>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 15%;">Cliente</th>
                    <th style="width: 12%;">Cajero</th>
                    <th style="width: 10%;" class="text-right">Total</th>
                    <th style="width: 10%;" class="text-center">Método</th>
                    <th style="width: 8%;" class="text-center">Estado</th>
                    <th style="width: 21%;">Productos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td><strong>{{ $sale->folio }}</strong></td>
                        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $sale->client ? $sale->client->full_name : 'Cliente general' }}</td>
                        <td>{{ $sale->user->name }}</td>
                        <td class="text-right">${{ number_format($sale->total_amount, 2) }}</td>
                        <td class="text-center">
                            <span class="payment-badge payment-{{ $sale->payment_method }}">
                                {{ ucfirst($sale->payment_method) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="status-badge status-{{ $sale->status }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td>
                            @foreach($sale->details as $detail)
                                {{ $detail->quantity }}x {{ $detail->item ? $detail->item->name : 'Producto no encontrado' }}
                                @if(!$loop->last), @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <table class="summary-table">
                <tr>
                    <td class="summary-label">Total de Ventas:</td>
                    <td class="summary-value">{{ $sales->count() }}</td>
                    <td class="summary-label">Monto Total:</td>
                    <td class="summary-value">${{ number_format($sales->sum('total_amount'), 2) }}</td>
                </tr>
                <tr>
                    <td class="summary-label">Ventas Completadas:</td>
                    <td class="summary-value">{{ $sales->where('status', 'completada')->count() }}</td>
                    <td class="summary-label">Monto Promedio:</td>
                    <td class="summary-value">${{ $sales->count() > 0 ? number_format($sales->sum('total_amount') / $sales->count(), 2) : '0.00' }}</td>
                </tr>
                <tr>
                    <td class="summary-label">Ventas Pendientes:</td>
                    <td class="summary-value">{{ $sales->where('status', 'pendiente')->count() }}</td>
                    <td class="summary-label">Ventas Canceladas:</td>
                    <td class="summary-value">{{ $sales->where('status', 'cancelada')->count() }}</td>
                </tr>
            </table>
        </div>
    @else
        <div class="no-data">
            <p>No se encontraron ventas con los filtros aplicados.</p>
        </div>
    @endif

    <div class="footer">
        <p>Reporte generado automáticamente por el sistema POS de {{ $appSettings['app_name'] ?? 'EBC' }}.</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>
