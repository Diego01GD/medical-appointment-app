<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos base para compatibilidad con clientes de correo */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #2c7be5; /* Azul Healthify */
            padding: 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #2c7be5;
            margin-top: 0;
        }
        .appointment-card {
            background-color: #f8f9fa;
            border-left: 4px solid #2c7be5;
            padding: 20px;
            margin: 25px 0;
        }
        .info-row {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }
        .label {
            font-weight: bold;
            color: #666;
            font-size: 14px;
        }
        .value {
            color: #333;
            font-weight: 500;
        }
        .footer {
            background-color: #f1f4f8;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #2c7be5;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Healthify</h1>
            <p>Tu salud en buenas manos</p>
        </div>

        <div class="content">
            <h2>¡Hola, {{ $paciente }}!</h2>
            <p>Tu cita médica ha sido programada exitosamente. Adjunto a este correo encontrarás el comprobante oficial en formato PDF.</p>
            
            <div class="appointment-card">
                <div class="info-row">
                    <span class="label">Doctor:</span>
                    <span class="value">{{ $doctor }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha:</span>
                    <span class="value">{{ $fecha }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Hora:</span>
                    <span class="value">{{ $hora }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Especialidad:</span>
                    <span class="value">{{ $especialidad }}</span>
                </div>
            </div>

            <p>Recuerda llegar 15 minutos antes de tu hora programada.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Healthify - Mérida, Yucatán.</p>
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
        </div>
    </div>
</body>
</html>
