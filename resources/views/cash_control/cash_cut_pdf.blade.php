<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Corte de Caja - {{ $cashCut->folio }}</title>
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

        /* Información */
        .info-section {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 30%;
            color: #000;
        }

        .info-value {
            color: #000;
        }

        /* Títulos de sección */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            color: #000;
        }

        /* Tablas de datos */
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

        /* Totales */
        .totals-section {
            margin-top: 10px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            page-break-inside: avoid;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px;
        }

        .totals-label {
            font-weight: bold;
            color: #000;
            width: 60%;
        }

        .totals-value {
            font-weight: bold;
            text-align: right;
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
                    <div class="report-title">REPORTE DE CORTE DE CAJA</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Folio de Corte:</td>
                <td class="info-value">{{ $cashCut->folio }}</td>
                <td class="info-label">Fecha y Hora:</td>
                <td class="info-value">{{ $cashCut->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <td class="info-label">Usuario:</td>
                <td class="info-value">{{ $cashCut->user->name ?? 'N/A' }}</td>
                <td class="info-label">Efectivo Esperado:</td>
                <td class="info-value">${{ number_format($cashCut->expected_cash, 2) }}</td>
            </tr>
            <tr>
                <td class="info-label">Efectivo Real:</td>
                <td class="info-value">${{ number_format($cashCut->actual_cash, 2) }}</td>
                <td class="info-label">Diferencia:</td>
                <td class="info-value" style="color: {{ $cashCut->difference < 0 ? 'red' : ($cashCut->difference > 0 ? 'green' : 'black') }}">
                    ${{ number_format($cashCut->difference, 2) }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Notas:</td>
                <td class="info-value" colspan="3">{{ $cashCut->notes ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Resumen de Ventas</div>
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td class="totals-label">Total de Ventas:</td>
                <td class="totals-value">{{ $sales->count() }}</td>
            </tr>
            <tr>
                <td class="totals-label">Monto Total de Ventas:</td>
                <td class="totals-value">${{ number_format($sales->sum('total_amount'), 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Ventas en Efectivo:</td>
                <td class="totals-value">${{ number_format($sales->where('payment_method', 'efectivo')->sum('total_amount'), 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Ventas con Tarjeta:</td>
                <td class="totals-value">${{ number_format($sales->where('payment_method', 'tarjeta')->sum('total_amount'), 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Ventas por Transferencia:</td>
                <td class="totals-value">${{ number_format($sales->where('payment_method', 'transferencia')->sum('total_amount'), 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Vouchers Registrados:</td>
                <td class="totals-value">{{ $voucherCount }}</td>
            </tr>
            @if($vouchers->count() > 0)
                <tr>
                    <td class="totals-label">Folios de Vouchers:</td>
                    <td class="totals-value" style="font-size: 9px; font-weight: normal;">{{ $vouchers->implode(', ') }}</td>
                </tr>
            @endif
        </table>
    </div>

    <div class="section-title">Detalle de Ventas</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">Folio</th>
                <th style="width: 15%;">Fecha</th>
                <th style="width: 15%;">Cajero</th>
                <th style="width: 25%;">Cliente</th>
                <th style="width: 15%;">Método Pago</th>
                <th style="width: 15%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->folio }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sale->user->name ?? 'N/A' }}</td>
                    <td>{{ $sale->client->full_name ?? 'Cliente General' }}</td>
                    <td>{{ ucfirst($sale->payment_method) }}</td>
                    <td class="text-right">${{ number_format($sale->total_amount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay ventas para mostrar en este corte.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado automáticamente por el sistema.</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>
