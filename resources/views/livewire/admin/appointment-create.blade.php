<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Search & Results -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Search Box -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Buscar disponibilidad</h3>
            <p class="text-sm text-gray-500 mb-4">Encuentra el horario perfecto para tu cita.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Fecha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fa-regular fa-calendar text-gray-500"></i>
                        </div>
                        <input type="date" wire:model.live="searchDate" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Especialidad (opcional)</label>
                    <select wire:model.live="selectedSpecialty" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Cualquier Especialidad</option>
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div wire:loading wire:target="searchDate, selectedSpecialty" class="text-sm text-blue-600 mb-2">
                Buscando disponibilidad...
            </div>
        </div>

        <!-- Dynamic Doctor Results -->
        <div class="space-y-4 relative">
            <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity">
                @if(count($availableDoctors) === 0)
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 text-center text-gray-500">
                        <i class="fa-solid fa-calendar-xmark text-4xl mb-3 text-gray-300"></i>
                        <p>No hay horarios disponibles para esta fecha o especialidad.</p>
                    </div>
                @else
                    @foreach($availableDoctors as $doctor)
                        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex flex-col md:flex-row items-start md:items-center mb-4">
                            <div class="flex items-center mb-4 md:mb-0 w-full md:w-1/3 lg:w-1/2">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl mr-4 flex-shrink-0">
                                    {{ substr($doctor['name'], 0, 2) }}
                                </div>
                                <div>
                                    <h4 class="text-md font-bold text-gray-900">Dr(a). {{ $doctor['name'] }}</h4>
                                    <p class="text-sm text-blue-600">{{ $doctor['specialty'] ?? 'Sin Especialidad' }}</p>
                                </div>
                            </div>
                            <div class="w-full md:w-2/3 lg:w-1/2 md:border-l border-gray-200 md:pl-6">
                                <p class="text-xs text-gray-500 mb-2">Horarios disponibles:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($doctor['slots'] as $slot)
                                        <button type="button" wire:click="selectSlot({{ $doctor['id'] }}, '{{ $doctor['name'] }}', '{{ $slot }}')" 
                                            class="px-4 py-2 rounded-md text-sm font-medium transition-colors 
                                            {{ $selectedDoctorId == $doctor['id'] && $selectedTime == $slot ? 'bg-blue-700 text-white shadow-md ring-2 ring-blue-300 ring-offset-1' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                                            {{ substr($slot, 0, 5) }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Summary & Submit -->
    <div class="lg:col-span-1">
        <form wire:submit.prevent="saveAppointment" class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Resumen de la cita</h3>
            
            <div class="space-y-3 text-sm mb-6 border-b border-gray-100 pb-6">
                <div class="flex justify-between">
                    <span class="text-gray-500">Doctor:</span>
                    <span class="font-medium text-gray-900">
                        @if($selectedDoctorName)
                            Dr(a). {{ $selectedDoctorName }}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Fecha:</span>
                    <span class="font-medium text-gray-900">{{ $searchDate ? \Carbon\Carbon::parse($searchDate)->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Horario:</span>
                    <span class="font-medium text-gray-900">
                        @if($selectedTime)
                            {{ substr($selectedTime, 0, 5) }} - {{ substr($endTime, 0, 5) }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>

            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paciente</label>
                    <select wire:model="patient_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">Selecciona paciente...</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    @error('selectedDoctorId') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de la cita (opcional)</label>
                    <textarea wire:model="reason" rows="3" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Escriba el motivo..."></textarea>
                </div>
            </div>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors disabled:opacity-50" 
                {{ !$selectedDoctorId ? 'disabled' : '' }}>
                Confirmar cita
            </button>
        </form>
    </div>
</div>
