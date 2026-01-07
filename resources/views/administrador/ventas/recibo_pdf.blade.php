<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Venta</title>
    <style>
        /* Es importante usar estilos simples para compatibilidad con librerías PDF como DomPDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #333;
        }
        .recibo-container {
            width: 350px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 15px;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 10px;
       
          
         
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .header p {
            margin: 3px 0;
            font-size: 11px;
        }
        .info-recibo, .info-cliente {
            margin-bottom: 15px;
        }
        .info-recibo p, .info-cliente p {
            margin: 5px 0;
            font-size: 12px;
        }
        .productos-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .productos-table th, .productos-table td {
            border: 1px solid #eee;
            padding: 8px;
            text-align: left;
        }
        .productos-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .totales {
            text-align: right;
            margin-bottom: 15px;
        }
        .totales p {
            margin: 5px 0;
            font-size: 12px;
        }
        .totales .total-final {
            font-size: 16px;
            font-weight: bold;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        .pago-info {
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
            padding: 10px 0;
            margin-bottom: 15px;
        }
        .pago-info p {
            margin: 5px 0;
            font-size: 12px;
        }
        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="recibo-container">
    <!-- CABECERA CON LOGO E INFORMACIÓN DE LA EMPRESA -->
    <div class="header">
        <img src="{{ public_path('recursos/logonegro.png') }}" alt="Logo del Negocio">
        
    </div>

    <!-- INFORMACIÓN DEL RECIBO -->
    <div class="info-recibo">
        <p><strong>Nº de Recibo:</strong> {{ $venta->id }}</p>
        <p><strong>Fecha y Hora:</strong> {{ $venta->created_at->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- INFORMACIÓN DEL CLIENTE -->
    <div class="info-cliente">
        <p><strong>Cliente:</strong> {{ $recibo->razon_social }}</p>
        <p><strong>CI/NIT:</strong> {{ $recibo->ci_nit }}{{ $recibo->complemento ? ' - ' . $recibo->complemento : '' }}</p>
    </div>

    <!-- TABLA DE PRODUCTOS -->
    <table class="productos-table">
        <thead>
            <tr>
                <th>Cant.</th>
                <th>Descripción</th>
                <th>P.U.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 2, ',', '.') }}</td>
                    <td>{{ number_format($detalle->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALES -->
    <div class="totales">
        <p><strong>Subtotal:</strong> Bs {{ number_format($venta->total, 2, ',', '.') }}</p>
        <!-- Puedes agregar impuestos aquí si es necesario -->
        <p class="total-final"><strong>TOTAL A PAGAR:</strong> Bs {{ number_format($venta->total, 2, ',', '.') }}</p>
    </div>

    <!-- INFORMACIÓN DE PAGO -->
    <div class="pago-info">
        <p><strong>Método de Pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
        <p><strong>Monto Recibido:</strong> Bs {{ number_format($venta->monto_recibido, 2, ',', '.') }}</p>
        <p><strong>Cambio:</strong> Bs {{ number_format($venta->vuelto, 2, ',', '.') }}</p>
    </div>

    <!-- PIE DE PÁGINA -->
    <div class="footer">
        <p>¡Gracias por su compra!</p>
        <p>Este no es un documento fiscal válido.</p>
    </div>
</div>

</body>
</html>
