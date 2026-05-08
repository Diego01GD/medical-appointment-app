<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background-color: #2c7be5; padding: 30px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; letter-spacing: 1px; }
        .content { padding: 40px 30px; }
        .content h2 { color: #2c7be5; margin-top: 0; }
        .info-card { background-color: #f8f9fa; border-left: 4px solid #2c7be5; padding: 20px; margin: 25px 0; }
        .footer { background-color: #f1f4f8; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        table.table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; font-size: 14px; }
        .table th { background-color: #f1f4f8; color: #555; }
        .time-badge { background-color: #e1effe; color: #1e429f; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 12px;}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Healthify</h1>
            <p>Reporte Automático de Citas</p>
        </div>

        <div class="content">
            <h2>¡Hola, Administrador!</h2>
            <p>Este es el resumen automático de todas las citas médicas programadas para el día de hoy (<strong>{{ \Carbon\Carbon::today()->format('d/m/Y') }}</strong>).</p>
            
            <div class="info-card">
                <strong>Total de citas de hoy:</strong> {{ $appointments->count() }}
            </div>

            @if($appointments->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Doctor</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td><span class="time-badge">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span></td>
                            <td>{{ $appointment->patient->user->name ?? 'Desconocido' }}</td>
                            <td>Dr(a). {{ $appointment->doctor->user->name ?? 'Desconocido' }}</td>
                            <td>Programada</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay citas programadas para el día de hoy en el sistema.</p>
            @endif

            <p style="margin-top: 30px; font-size: 14px; color: #666;">Para ver más detalles, por favor ingrese al panel de administración de Healthify.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Healthify - Mérida, Yucatán.</p>
            <p>Este es un reporte automático diario, por favor no respondas a este correo.</p>
        </div>
    </div>
</body>
</html>
