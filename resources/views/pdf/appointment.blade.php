<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Cita Médica</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 3px solid #2c7be5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c7be5;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #f8f9fa;
            border-left: 4px solid #2c7be5;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: bold;
            color: #2c7be5;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px 0;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .value {
            color: #000;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e1effe;
            color: #1e429f;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Healthify</h1>
        <p>Tu salud en buenas manos | Comprobante Oficial de Cita Médica</p>
    </div>

    <div class="section">
        <div class="section-title">Detalles de la Cita</div>
        <table>
            <tr>
                <td class="label">Folio de Cita:</td>
                <td class="value">#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Fecha Programada:</td>
                <td class="value"><span class="badge">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</span></td>
            </tr>
            <tr>
                <td class="label">Hora:</td>
                <td class="value"><span class="badge">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} hrs</span></td>
            </tr>
            <tr>
                <td class="label">Motivo (Opcional):</td>
                <td class="value">{{ $appointment->reason ?: 'No especificado' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Datos del Paciente</div>
        <table>
            <tr>
                <td class="label">Nombre:</td>
                <td class="value">{{ $appointment->patient->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Correo Electrónico:</td>
                <td class="value">{{ $appointment->patient->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Teléfono:</td>
                <td class="value">{{ $appointment->patient->user->phone ?? 'No registrado' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Datos del Médico</div>
        <table>
            <tr>
                <td class="label">Doctor(a):</td>
                <td class="value">Dr(a). {{ $appointment->doctor->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Especialidad:</td>
                <td class="value">{{ $appointment->doctor->specialty ?? 'Medicina General' }}</td>
            </tr>
            <tr>
                <td class="label">Contacto Médico:</td>
                <td class="value">{{ $appointment->doctor->user->email }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Por favor, preséntese en la clínica 15 minutos antes de su cita.</p>
        <p>Documento generado el {{ now()->format('d/m/Y H:i') }} - Healthify © {{ date('Y') }}</p>
    </div>
</body>
</html>
