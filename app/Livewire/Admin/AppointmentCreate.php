<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

class AppointmentCreate extends Component
{
    public $searchDate;
    public $selectedSpecialty = '';
    
    // Lista de opciones
    public $specialties = [];
    public $patients = [];
    
    // Resultados
    public $availableDoctors = [];

    // Selección de cita
    public $selectedDoctorId = '';
    public $selectedDoctorName = '';
    public $selectedTime = '';
    public $endTime = '';
    
    // Datos del formulario
    public $patient_id = '';
    public $reason = '';

    public function mount()
    {
        $this->searchDate = date('Y-m-d');
        $this->specialties = Doctor::whereNotNull('specialty')->distinct()->pluck('specialty')->toArray();
        $this->patients = Patient::with('user')->get();
        $this->searchAvailability();
    }

    public function updatedSearchDate()
    {
        $this->resetSelection();
        $this->searchAvailability();
    }

    public function updatedSelectedSpecialty()
    {
        $this->resetSelection();
        $this->searchAvailability();
    }

    private function resetSelection()
    {
        $this->selectedDoctorId = '';
        $this->selectedDoctorName = '';
        $this->selectedTime = '';
        $this->endTime = '';
    }

    public function selectSlot($doctorId, $doctorName, $time)
    {
        $this->selectedDoctorId = $doctorId;
        $this->selectedDoctorName = $doctorName;
        $this->selectedTime = $time;
        // Asumimos consultas de 15 minutos (por defecto en tu sistema de horarios)
        // Puedes cambiarlo a 30 si lo prefieres, usaremos 30 según la vista anterior
        $this->endTime = Carbon::parse($time)->addMinutes(30)->format('H:i:s');
    }

    public function searchAvailability()
    {
        if (!$this->searchDate) {
            $this->availableDoctors = [];
            return;
        }

        // Obtener el día de la semana en español
        $dayOfWeek = Carbon::parse($this->searchDate)->locale('es')->isoFormat('dddd');
        $dayOfWeek = ucfirst($dayOfWeek); // Lunes, Martes...

        // Buscar doctores que coincidan con la especialidad (si hay) y que tengan horarios este día
        $query = Doctor::with(['user', 'schedules' => function ($q) use ($dayOfWeek) {
            $q->where('day', $dayOfWeek)->orderBy('start_time');
        }])->whereHas('schedules', function ($q) use ($dayOfWeek) {
            $q->where('day', $dayOfWeek);
        });

        if ($this->selectedSpecialty) {
            $query->where('specialty', $this->selectedSpecialty);
        }

        $doctors = $query->get();

        // Ahora filtrar las horas que ya están ocupadas
        $this->availableDoctors = [];

        foreach ($doctors as $doctor) {
            $slots = [];
            // Obtener citas ya agendadas para este doctor en esta fecha
            $bookedAppointments = Appointment::where('doctor_id', $doctor->id)
                ->where('date', $this->searchDate)
                ->where('status', '!=', 3) // No considerar canceladas
                ->get();

            foreach ($doctor->schedules as $schedule) {
                // Formato H:i:s
                $time = $schedule->start_time;
                $isBooked = false;

                foreach ($bookedAppointments as $booked) {
                    // Validar si la hora coincide (simplificado a cruce exacto de inicio)
                    // Si se requieren cruces más complejos, se compara con start_time y end_time
                    if ($time >= $booked->start_time && $time < $booked->end_time) {
                        $isBooked = true;
                        break;
                    }
                }

                if (!$isBooked) {
                    $slots[] = substr($time, 0, 8); // Asegurar H:i:s
                }
            }

            if (count($slots) > 0) {
                $this->availableDoctors[] = [
                    'id' => $doctor->id,
                    'name' => $doctor->user->name,
                    'specialty' => $doctor->specialty,
                    'slots' => $slots
                ];
            }
        }
    }

    public function saveAppointment()
    {
        $this->validate([
            'patient_id' => 'required',
            'selectedDoctorId' => 'required',
            'searchDate' => 'required|date',
            'selectedTime' => 'required',
        ], [
            'patient_id.required' => 'Debe seleccionar un paciente.',
            'selectedDoctorId.required' => 'Debe seleccionar un horario de la lista.',
        ]);

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->selectedDoctorId,
            'date' => $this->searchDate,
            'start_time' => $this->selectedTime,
            'end_time' => $this->endTime,
            'reason' => $this->reason,
            'status' => 1, // Programada
        ]);

        session()->flash('success', 'Cita agendada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.appointment-create')
            ->layout('layouts.admin', [
                'breadcrumbs' => [
                    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                    ['name' => 'Citas', 'href' => route('admin.appointments.index')],
                    ['name' => 'Nuevo'],
                ]
            ])
            ->title('Agendar Cita');
    }
}
