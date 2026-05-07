<x-admin-layout title="Editar Doctor" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
  ],
  [
    'name' => 'Doctores',
    'href' => route('admin.doctors.index'),
  ],
  [
    'name' => 'Editar',
  ],
]">

<div class="bg-white shadow-md sm:rounded-lg overflow-hidden border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Editar Doctor: {{ $doctor->user->name }}</h3>
    
    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Datos de Usuario -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Información Personal</h4>
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $doctor->user->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $doctor->user->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">DNI / Identificación</label>
                    <input type="text" id="id_number" name="id_number" value="{{ old('id_number', $doctor->user->id_number) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    @error('id_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $doctor->user->phone) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Datos de Doctor -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Información Profesional</h4>
                
                <div>
                    <label for="specialty" class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                    <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $doctor->specialty) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    @error('specialty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="license_number" class="block text-sm font-medium text-gray-700 mb-1">Número de Licencia / Cédula</label>
                    <input type="text" id="license_number" name="license_number" value="{{ old('license_number', $doctor->license_number) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('license_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-4">
            <a href="{{ route('admin.doctors.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 font-medium text-sm">Cancelar</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-sm transition-colors">
                Actualizar Doctor
            </button>
        </div>
    </form>
</div>

</x-admin-layout>
