<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use App\Mail\AdminDailyReportMail;
use App\Mail\DoctorDailyReportMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyAppointmentReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-daily-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía el reporte diario de citas a los administradores y a cada doctor.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando el envío de reportes diarios de citas...');

        // 1. Obtener todas las citas del día actual
        $today = Carbon::today()->toDateString();
        
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date', $today)
            ->where('status', '!=', 3) // Excluir canceladas si existiera el estado
            ->orderBy('start_time')
            ->get();

        if ($appointments->isEmpty()) {
            $this->info('No hay citas programadas para el día de hoy.');
            // Puedes decidir si enviar un correo de "No hay citas" o no hacer nada. 
            // En este caso, no enviamos nada si no hay citas.
            return;
        }

        // 2. Enviar reporte general a Administradores
        $admins = User::role('Administrador')->get();
        if ($admins->isNotEmpty()) {
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new AdminDailyReportMail($appointments));
            }
            $this->info('Reporte general enviado a ' . $admins->count() . ' administradores.');
        } else {
            $this->warn('No se encontraron usuarios con el rol "Administrador".');
        }

        // 3. Agrupar citas por Doctor y enviar reporte individual
        // Agrupamos usando el doctor_id
        $appointmentsByDoctor = $appointments->groupBy('doctor_id');

        foreach ($appointmentsByDoctor as $doctorId => $doctorAppointments) {
            $doctor = Doctor::with('user')->find($doctorId);
            if ($doctor && $doctor->user && $doctor->user->email) {
                Mail::to($doctor->user->email)->send(new DoctorDailyReportMail($doctor, $doctorAppointments));
            }
        }

        $this->info('Reportes individuales enviados a ' . $appointmentsByDoctor->count() . ' doctores.');
        $this->info('Proceso finalizado exitosamente.');
    }
}
