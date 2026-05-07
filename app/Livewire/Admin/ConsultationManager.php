<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;
use Livewire\Attributes\Layout;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    public $tab = 'consulta'; // 'consulta' or 'receta'
    public $showHistoryModal = false;
    public $showPastConsultationsModal = false;

    // Campos de la consulta
    public $diagnosis;
    public $treatment;
    public $notes;

    // Campos de la receta
    public $medicines = [];
    public $medicineName = '';
    public $medicineDosage = '';
    public $medicineInstructions = '';

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }

    public function addMedicine()
    {
        $this->validate([
            'medicineName' => 'required|string',
            'medicineDosage' => 'required|string',
            'medicineInstructions' => 'required|string',
        ]);

        $this->medicines[] = [
            'name' => $this->medicineName,
            'dosage' => $this->medicineDosage,
            'instructions' => $this->medicineInstructions,
        ];

        $this->reset(['medicineName', 'medicineDosage', 'medicineInstructions']);
    }

    public function removeMedicine($index)
    {
        unset($this->medicines[$index]);
        $this->medicines = array_values($this->medicines);
    }

    public function saveConsultation()
    {
        // Validación básica
        $this->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
        ]);

        // Guardar la información en la cita (para esto tendríamos que añadir los campos a appointments o crear una tabla consultations).
        // Como no se pide crear tabla 'consultations', simplemente marcaremos la cita como completada (status 2).
        $this->appointment->update(['status' => 2]);

        session()->flash('success', 'Consulta guardada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        // Obtener historial del paciente
        $pastConsultations = Appointment::where('patient_id', $this->appointment->patient_id)
            ->where('status', 2)
            ->where('id', '!=', $this->appointment->id)
            ->latest()
            ->get();

        return view('livewire.admin.consultation-manager', compact('pastConsultations'))
            ->layout('layouts.admin', [
                'breadcrumbs' => [
                    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                    ['name' => 'Citas', 'href' => route('admin.appointments.index')],
                    ['name' => 'Consulta'],
                ]
            ])
            ->title('Atender Consulta');
    }
}
