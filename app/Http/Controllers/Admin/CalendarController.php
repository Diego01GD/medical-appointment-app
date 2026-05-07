<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class CalendarController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])->get();
        
        $events = [];
        foreach ($appointments as $appointment) {
            $patientName = $appointment->patient->user->name ?? 'Paciente';
            $startTime = \Carbon\Carbon::parse($appointment->start_time)->format('H:i');
            
            // Colores por estado
            $color = '#3b82f6'; // blue-500 (Programado)
            if ($appointment->status == 2) $color = '#10b981'; // green-500 (Completado)
            if ($appointment->status == 3) $color = '#ef4444'; // red-500 (Cancelado)

            $events[] = [
                'id' => $appointment->id,
                'title' => $startTime . ' ' . $patientName,
                'start' => $appointment->date . 'T' . $appointment->start_time,
                'end' => $appointment->date . 'T' . $appointment->end_time,
                'color' => $color,
                'url' => route('admin.consultations.show', $appointment->id), // Enlace a la consulta
            ];
        }

        return view('admin.calendar.index', compact('events'));
    }
}
