<div class="bg-white shadow-md sm:rounded-lg overflow-hidden border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Gestor de horarios</h3>
            <p class="text-sm text-gray-500">Configurando horarios para Dr(a). {{ $doctor->user->name }}</p>
        </div>
        <button wire:click="saveSchedules" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-sm transition-colors flex items-center">
            <i class="fa-solid fa-save mr-2"></i> Guardar horario
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-500 uppercase border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-4 py-4 w-40 text-gray-900 font-bold">DÍA/HORA</th>
                    @foreach($days as $day)
                        <th scope="col" class="px-4 py-4">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($hours as $hour)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-6 font-bold text-gray-900 align-top">
                            {{ $hour }}:00
                        </td>
                        @foreach($days as $day)
                            <td class="px-4 py-6 align-top">
                                <div class="space-y-3">
                                    <!-- Todos Checkbox -->
                                    <label class="flex items-center space-x-2 cursor-pointer mb-2">
                                        <input type="checkbox" wire:click="toggleAll('{{ $day }}', '{{ $hour }}')" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" 
                                        @php
                                            $allChecked = true;
                                            foreach($intervals as $min) {
                                                if(!isset($selectedSlots[$day][$hour.':'.$min]) || !$selectedSlots[$day][$hour.':'.$min]) {
                                                    $allChecked = false;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if($allChecked) checked @endif>
                                        <span class="text-sm font-medium text-gray-700">Todos</span>
                                    </label>
                                    
                                    <!-- 15 min slots -->
                                    @foreach($intervals as $index => $min)
                                        @php
                                            $startTime = $hour . ':' . $min;
                                            $endMin = isset($intervals[$index+1]) ? $intervals[$index+1] : '00';
                                            $endHour = isset($intervals[$index+1]) ? $hour : sprintf('%02d', intval($hour) + 1);
                                            $endTime = $endHour . ':' . $endMin;
                                        @endphp
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="checkbox" wire:model="selectedSlots.{{ $day }}.{{ $startTime }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="text-sm {{ isset($selectedSlots[$day][$startTime]) && $selectedSlots[$day][$startTime] ? 'font-bold text-blue-700' : 'text-gray-600' }}">
                                                {{ $startTime }} - {{ $endTime }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
