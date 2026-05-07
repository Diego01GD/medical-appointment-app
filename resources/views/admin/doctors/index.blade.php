<x-admin-layout title="Doctores" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
  ],
  [
    'name' => 'Doctores',
  ],
]">

<div class="bg-white shadow-md sm:rounded-lg overflow-hidden border border-gray-100">
    <!-- Card Header -->
    <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4">
        <h2 class="text-xl font-bold text-gray-800">Doctores</h2>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4 rounded" role="alert">
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
                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 shadow-sm" placeholder="Buscar...">
                </div>
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <button type="button" class="flex items-center justify-center w-full md:w-auto text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2 shadow-sm">
                Columnas <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
            <button type="button" class="flex items-center justify-center w-full md:w-auto text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2 shadow-sm">
                10 <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-y border-gray-100">
                <tr>
                    <th scope="col" class="px-4 py-3">ID <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">NOMBRE <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">EMAIL <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">DNI <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">TELEFONO <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3">ESPECIALIDAD <i class="fa-solid fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($doctors as $doctor)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $doctor->id }}</td>
                        <td class="px-4 py-4 font-medium text-gray-900">Dr. {{ $doctor->user->name }}</td>
                        <td class="px-4 py-4">{{ $doctor->user->email }}</td>
                        <td class="px-4 py-4">{{ $doctor->user->id_number }}</td>
                        <td class="px-4 py-4">{{ $doctor->user->phone ?? 'N/A' }}</td>
                        <td class="px-4 py-4">{{ $doctor->specialty }}</td>
                        <td class="px-4 py-4 flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="bg-blue-500 text-white rounded p-1.5 hover:bg-blue-600 shadow-sm transition-colors" title="Editar">
                                <i class="fa-solid fa-pencil text-xs"></i>
                            </a>
                            <a href="{{ route('admin.doctor-schedules', $doctor) }}" class="bg-green-500 text-white rounded p-1.5 hover:bg-green-600 shadow-sm transition-colors" title="Horarios">
                                <i class="fa-solid fa-clock text-xs"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay doctores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-between items-center">
        <div class="text-sm text-gray-500">
            Mostrando resultados
        </div>
        <div>
            {{ $doctors->links() }}
        </div>
    </div>
</div>

</x-admin-layout>
