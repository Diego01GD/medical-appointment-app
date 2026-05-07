<x-admin-layout title="Citas" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
  ],
  [
    'name' => 'Citas',
  ],
]">

<div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
    <!-- Card Header -->
    <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4">
        <h2 class="text-xl font-bold text-gray-800">Citas</h2>
        <a href="{{ route('admin.appointments.create') }}" class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/2">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Buscar</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-search text-gray-500"></i>
                    </div>
                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2" placeholder="Buscar..." >
                </div>
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <button type="button" class="flex items-center justify-center w-full md:w-auto text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2">
                Columnas <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
            <button type="button" class="flex items-center justify-center w-full md:w-auto text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2">
                10 <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3">ID <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">PACIENTE <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">DOCTOR <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">FECHA <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">HORA <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">HORA FIN <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">ESTADO</th>
                    <th scope="col" class="px-4 py-3 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $appointment->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</td>
                        <td class="px-4 py-3">
                            @if ($appointment->status == 1)
                                Programado
                            @elseif ($appointment->status == 2)
                                Completado
                            @else
                                Cancelado
                            @endif
                        </td>
                        <td class="px-4 py-3 flex items-center justify-center space-x-2">
                            <a href="#" class="bg-blue-500 text-white rounded p-1.5 hover:bg-blue-600 transition-colors" title="Editar">
                                <i class="fa-solid fa-pencil text-xs"></i>
                            </a>
                            <a href="{{ route('admin.consultations.show', $appointment->id) }}" class="bg-green-500 text-white rounded p-1.5 hover:bg-green-600 transition-colors" title="Consulta">
                                <i class="fa-solid fa-file-lines text-xs"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-3 text-center text-gray-500">No hay citas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4">
        {{ $appointments->links() }}
    </div>
</div>

</x-admin-layout>
