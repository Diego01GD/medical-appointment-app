<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use App\Models\Schedule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DoctorScheduleManager extends Component
{
    public Doctor $doctor;
    public $selectedSlots = [];
    public $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
    public $hours = ['08', '09', '10', '11', '12', '13', '14', '15', '16', '17'];
    public $intervals = ['00', '15', '30', '45'];

    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $schedules = $this->doctor->schedules;
        foreach ($schedules as $schedule) {
            $startHour = substr($schedule->start_time, 0, 2); // HH
            $startMin = substr($schedule->start_time, 3, 2); // mm
            
            // Reconstruir la llave para coincidir con wire:model
            $timeKey = $startHour . ':' . $startMin;

            // En el frontend, el wire model es $hour . ':' . $min, pero el indice principal de las casillas en la vista es `$hour` de la lista de horas.
            // Para que funcione, revisemos cómo está en la vista:
            // wire:model="selectedSlots.{{ $day }}.{{ $startTime }}" donde $startTime = $hour . ':' . $min;
            $this->selectedSlots[$schedule->day][$timeKey] = true;
        }
    }

    public function toggleAll($day, $hour)
    {
        $allChecked = true;
        foreach ($this->intervals as $min) {
            $time = $hour . ':' . $min;
            if (!isset($this->selectedSlots[$day][$time]) || !$this->selectedSlots[$day][$time]) {
                $allChecked = false;
                break;
            }
        }

        foreach ($this->intervals as $min) {
            $time = $hour . ':' . $min;
            if ($allChecked) {
                unset($this->selectedSlots[$day][$time]);
            } else {
                $this->selectedSlots[$day][$time] = true;
            }
        }
    }

    public function saveSchedules()
    {
        // Limpiar horarios actuales
        $this->doctor->schedules()->delete();

        // Guardar nuevos horarios
        foreach ($this->selectedSlots as $day => $times) {
            foreach ($times as $time => $isChecked) {
                if ($isChecked) {
                    $endTime = \Carbon\Carbon::parse($time)->addMinutes(15)->format('H:i:s');
                    $this->doctor->schedules()->create([
                        'day' => $day,
                        'start_time' => $time,
                        'end_time' => $endTime,
                    ]);
                }
            }
        }

        session()->flash('success', 'Horarios guardados exitosamente.');
    }

    public function render()
    {
        return view('livewire.admin.doctor-schedule-manager')
            ->layout('layouts.admin', [
                'breadcrumbs' => [
                    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                    ['name' => 'Doctores', 'href' => route('admin.doctors.index')],
                    ['name' => 'Horarios'],
                ]
            ])
            ->title('Gestor de horarios');
    }
}
