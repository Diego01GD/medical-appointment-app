<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendWhatsAppReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-whatsapp-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de WhatsApp automáticos a los pacientes 3 días antes de su cita.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando el envío de recordatorios por WhatsApp...');

        // Calcular la fecha objetivo: exactamente 3 días después de hoy
        // NOTA PARA EL USUARIO: Si quieres volver a 2 días, cambia el número en "addDays(3)"
        $targetDate = Carbon::today()->addDays(1)->toDateString();
        
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date', $targetDate)
            ->where('status', '!=', 3) // Excluir canceladas
            ->get();

        if ($appointments->isEmpty()) {
            $this->info("No hay citas programadas para el día {$targetDate}.");
            return;
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($appointments as $appointment) {
            $patient = $appointment->patient->user;
            $doctor = $appointment->doctor->user;

            if (empty($patient->phone)) {
                $this->warn("El paciente {$patient->name} no tiene teléfono registrado.");
                $failedCount++;
                continue;
            }

            // 1. Limpiar y formatear el número
            // Quitar todo lo que no sea número
            $cleanPhone = preg_replace('/[^0-9]/', '', $patient->phone);
            
            // Si el número tiene más de 10 dígitos (ej: incluyó 52), tomamos solo los últimos 10
            if (strlen($cleanPhone) >= 10) {
                $cleanPhone = substr($cleanPhone, -10);
            } else {
                $this->warn("El teléfono de {$patient->name} no es válido ({$patient->phone}).");
                $failedCount++;
                continue;
            }

            // Añadir el código de país y prefijo de CallMeBot para México
            $formattedPhone = '52' . $cleanPhone;

            // 2. Construir el mensaje
            // Obtenemos solo el apellido del doctor (asumiendo que el nombre puede venir como "Juan Perez")
            $doctorNames = explode(' ', trim($doctor->name));
            $doctorLastName = count($doctorNames) > 1 ? end($doctorNames) : $doctor->name;
            
            $formattedDate = Carbon::parse($appointment->date)->format('d/m/Y');
            $formattedTime = Carbon::parse($appointment->start_time)->format('H:i');

            $message = "Hola {$patient->name}, Healthify te informa que tu cita con el Dr. {$doctorLastName} ha sido agendada para el día {$formattedDate} a las {$formattedTime}. ¡Te esperamos! Recuerda llegar 15 minutos antes.";

            // 3. Enviar la petición a CallMeBot
            try {
                $response = Http::get('https://api.callmebot.com/whatsapp.php', [
                    'phone' => $formattedPhone,
                    'text' => $message,
                    'apikey' => '2388890'
                ]);

                if ($response->successful()) {
                    $this->line("✅ Mensaje enviado a {$patient->name} ({$formattedPhone})");
                    $sentCount++;
                } else {
                    $this->error("❌ Error enviando a {$patient->name}: " . $response->body());
                    $failedCount++;
                }
            } catch (\Exception $e) {
                $this->error("❌ Excepción enviando a {$patient->name}: " . $e->getMessage());
                $failedCount++;
            }
        }

        $this->info("Proceso finalizado. Mensajes enviados: {$sentCount}, Fallidos: {$failedCount}");
    }
}
