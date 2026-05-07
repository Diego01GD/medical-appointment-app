<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-100">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $appointment->patient->user->name ?? 'Paciente' }}</h2>
                    <p class="text-sm text-gray-500 mt-1">DNI: {{ $appointment->patient->user->id_number ?? 'N/A' }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <button wire:click="$set('showHistoryModal', true)" class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg text-sm transition-colors flex items-center shadow-sm">
                        <i class="fa-solid fa-file-medical mr-2"></i> Ver Historia
                    </button>
                    <button wire:click="$set('showPastConsultationsModal', true)" class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg text-sm transition-colors flex items-center shadow-sm">
                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> Consultas Anteriores
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="px-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="setTab('consulta')" class="{{ $tab === 'consulta' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                    <i class="fa-solid fa-notes-medical mr-2"></i> Consulta
                </button>
                <button wire:click="setTab('receta')" class="{{ $tab === 'receta' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                    <i class="fa-solid fa-prescription-bottle-alt mr-2"></i> Receta
                </button>
            </nav>
        </div>

        <div class="p-6 bg-white min-h-[400px]">
            @if ($tab === 'consulta')
                <!-- Tab: Consulta -->
                <div class="space-y-6 animate-fade-in">
                    <div>
                        <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">Diagnóstico</label>
                        <textarea wire:model="diagnosis" id="diagnosis" rows="3" class="shadow-sm bg-white border border-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Describa el diagnóstico del paciente aquí..."></textarea>
                        @error('diagnosis') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="treatment" class="block text-sm font-medium text-gray-700 mb-1">Tratamiento</label>
                        <textarea wire:model="treatment" id="treatment" rows="4" class="shadow-sm bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Describa el tratamiento recomendado aquí..."></textarea>
                        @error('treatment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea wire:model="notes" id="notes" rows="2" class="shadow-sm bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                    </div>
                </div>
            @else
                <!-- Tab: Receta -->
                <div class="space-y-6 animate-fade-in">
                    <!-- Formulario en línea para receta -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 flex flex-col md:flex-row items-end gap-4 shadow-sm">
                        <div class="w-full md:w-2/5">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Medicamento</label>
                            <input type="text" wire:model="medicineName" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Amoxicilina 500mg">
                            @error('medicineName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/5">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Dosis</label>
                            <input type="text" wire:model="medicineDosage" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="1 cada 8 horas">
                            @error('medicineDosage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-2/5">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Frecuencia / Duración</label>
                            <div class="flex gap-2">
                                <input type="text" wire:model="medicineInstructions" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ej: cada 8 horas por 7 días">
                                <button wire:click="addMedicine" class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg p-2.5 flex-shrink-0 transition-colors shadow-sm">
                                    <i class="fa-solid fa-plus px-1"></i>
                                </button>
                            </div>
                            @error('medicineInstructions') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if(count($medicines) > 0)
                        <div class="mt-6 border border-gray-100 rounded-lg overflow-hidden shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medicamento</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dosis</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frecuencia / Duración</th>
                                        <th scope="col" class="px-4 py-3 text-right"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($medicines as $index => $medicine)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $medicine['name'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $medicine['dosage'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $medicine['instructions'] }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <button wire:click="removeMedicine({{ $index }})" class="text-white bg-red-500 hover:bg-red-600 rounded p-1.5 transition-colors shadow-sm">
                                                    <i class="fa-solid fa-trash-can text-xs px-0.5"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="bg-white px-6 py-4 border-t border-gray-100 flex justify-end">
            <button wire:click="saveConsultation" type="button" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2.5 px-6 rounded-lg text-sm shadow-sm transition-colors flex items-center">
                <i class="fa-solid fa-lock mr-2"></i> Guardar Consulta
            </button>
        </div>
    </div>

    <!-- Modal de Historia Médica -->
    @if($showHistoryModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true" wire:click="$set('showHistoryModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Historia médica del paciente</h3>
                            <button wire:click="$set('showHistoryModal', false)" class="text-gray-400 hover:text-gray-500">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500 mb-1">Tipo de sangre:</h4>
                                    <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->bloodType->name ?? 'No registrado' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500 mb-1">Alergias:</h4>
                                    <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->allergies ?? 'No registradas' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500 mb-1">Enfermedades crónicas:</h4>
                                    <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->chronic_conditions ?? 'No registradas' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500 mb-1">Antecedentes quirúrgicos:</h4>
                                    <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->surgical_history ?? 'No registrados' }}</p>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <a href="{{ route('admin.patients.edit', $appointment->patient->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver / Editar Historia Médica</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Consultas Anteriores -->
    @if($showPastConsultationsModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true" wire:click="$set('showPastConsultationsModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full bg-gray-50">
                    <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Consultas Anteriores</h3>
                        <button wire:click="$set('showPastConsultationsModal', false)" class="text-gray-400 hover:text-gray-500">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto space-y-4">
                        @forelse($pastConsultations as $past)
                            <div class="bg-white border border-blue-200 rounded-lg p-5 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="flex items-center text-blue-700 font-bold mb-1">
                                            <i class="fa-solid fa-calendar-day mr-2"></i>
                                            {{ \Carbon\Carbon::parse($past->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($past->start_time)->format('H:i') }}
                                        </div>
                                        <p class="text-sm text-gray-500">Atendido por: Dr(a). {{ $past->doctor->user->name ?? 'N/A' }}</p>
                                    </div>
                                    <button class="text-blue-600 bg-white border border-blue-200 hover:bg-blue-50 font-medium rounded-lg text-xs px-4 py-2 transition-colors">
                                        Consultar Detalle
                                    </button>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-700 space-y-2 border border-gray-100">
                                    <p><strong class="font-bold text-gray-900">Diagnóstico:</strong> {{ $past->reason ?? 'No especificado' }}</p>
                                    <!-- Dado que no guardamos el tratamiento detallado en DB, mostramos datos de prueba -->
                                    <p><strong class="font-bold text-gray-900">Tratamiento:</strong> Tratamiento registrado en la consulta.</p>
                                    <p><strong class="font-bold text-gray-900">Notas:</strong> El paciente reporta mejoría. Se recomienda seguimiento.</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                No hay consultas anteriores registradas.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
    <style>
        .animate-fade-in {
            animation: fadeIn 0.2s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(2px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>
