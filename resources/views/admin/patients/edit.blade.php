<x-admin-layout title="Pacientes" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
  ],
  [
    'name' => 'Pacientes',
    'href' => route('admin.patients.index'),
  ],
  [
    'name' => 'Editar',
  ],
]">


  <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
    @csrf
    @method('PUT')
    {{-- Encabezado con foto y acciones --}}
    <x-wire-card class="mb-8">
      <div class="lg:flex lg:justify-between lg:items-center">
        <div class="flex items-center">
          <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}" class="h-20 w-20 rounded-full object-cover">
          <div>
            <p class="text-2xl font-bold text-gray-900 ml-4">{{ $patient->user->name }}</p>
          </div>
        </div>

        <div class="flex space-x-3 mt-6 lg:mb-0">
          <x-wire-button outline gray href="{{ route('admin.patients.index') }}">Volver</x-wire-button>
          <x-wire-button type="submit">
            <i class="fa-solid fa-check"></i>
            Guardar Cambios
          </x-wire-button>
        </div>
      </div>
    </x-wire-card>

    {{-- Tabs de Navegacion --}}
    <x-wire-card>
      <div x-data="{tab: 'datos-personales'}">
        {{-- Menu de Pestanas --}}
        <div class="border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">

              {{-- Tab 1: Datos Personales --}}
                <li class="me-2">
                    <a href="#" x-on:click="tab ='datos-personales'" 
                    :class="{
                      'text-blue-600 border-blue-600 active': tab === 'datos-personales', 
                      'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'datos-personales'}"
                      class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                      :aria-current="tab === 'datos-personales' ? 'page' : undifined">
                        <i class="fa-solid fa-user me-2"></i>
                        Datos Personales
                    </a>
                </li>

                {{-- Tab 2: Antecedentes --}}
                <li class="me-2">
                    <a href="#" x-on:click="tab ='antecedentes'" 
                    :class="{
                      'text-blue-600 border-blue-600 active': tab === 'antecedentes', 
                      'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'antecedentes'}"
                      class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                      :aria-current="tab === 'antecedentes' ? 'page' : undefined">
                        <i class="fa-solid fa-file-lines me-2"></i>
                        Antecedentes
                    </a>
                </li>

                {{-- Tab 3: Informacion General --}}
                <li class="me-2">
                    <a href="#" x-on:click="tab ='informacion-general'" 
                    :class="{
                      'text-blue-600 border-blue-600 active': tab === 'informacion-general', 
                      'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'informacion-general'}"
                      class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                      :aria-current="tab === 'informacion-general' ? 'page' : undefined">
                        <i class="fa-solid fa-info me-2"></i>
                        Información General
                    </a>
                </li>

                {{-- Tab 4: Contacto de Emergencia --}}
                <li class="me-2">
                    <a href="#" x-on:click="tab ='contacto-emergencia'" 
                    :class="{
                      'text-blue-600 border-blue-600 active': tab === 'contacto-emergencia', 
                      'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'contacto-emergencia'}"
                      class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                      :aria-current="tab === 'contacto-emergencia' ? 'page' : undefined">
                        <i class="fa-solid fa-heart me-2"></i>
                        Contacto de Emergencia
                    </a>
                </li>
            </ul>
        </div>

        {{-- Contenido de los Tabs --}}
        <div class="px-4 mt-4">
          {{-- Contenido 1: Datos Personales --}}

          <div x-show="tab ==='datos-personales'">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">

              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-1"></i>
                  </div>
                    <div class="ml-3">
                      <h3 class="text-sm font-bold text-blue-800">
                        Edicion de Cuenta de Usuario
                      </h3>
                      <div class="mt-1 text-sm text-blue-600">
                        <p>La <strong>Informacion de acceso</strong> (Nombre, Email y Contraseña) debe gestionarse desde la cuenta de Usuario asociada</p>
                      </div>
                    </div>
                </div>  
                  {{-- Lado Derecho: Boton de Accion --}}

                  <div class="flex-shrink-0">
                    <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user) }}" target="_blank"> Editar Usuario <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i></x-wire-button>
                  </div>

              </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-4">
              <div>
                <span class="text-gray-500 font-semibold">Telefono:</span>
                <span class="text-gray-900 text-sm ml-1">{{ $patient->user->phone }}</span>
              </div>
              <div>
                <span class="text-gray-500 font-semibold">Email:</span>
                <span class="text-gray-900 text-sm ml-1">{{ $patient->user->email }}</span>
              </div>
              <div>
                <span class="text-gray-500 font-semibold">Direccion:</span>
                <span class="text-gray-900 text-sm ml-1">{{ $patient->user->address }}</span>
              </div>
            </div>

          </div>

          {{-- Contenido de Tab2: Antecedentes --}}
          <div x-show="tab === 'antecedentes'" style="display: none">
            <div class="grid lg:grid-cols-2 gap-4">
              <div>
                <x-wire-textarea label="Alergias Conocidas" name="allergies">
                  {{ old('allergies', $patient->allergies) }}
                </x-wire-textarea>
              </div>
              <div>
                <x-wire-textarea label="Enfermedades Cronicas" name="chronic_conditions">
                  {{ old('chronic_conditions', $patient->chronic_conditions) }}
                </x-wire-textarea>
              </div>
              <div>
                <x-wire-textarea label="Antecedentes Quirurgicos" name="surgical_history">
                  {{ old('surgical_history', $patient->surgical_history) }}
                </x-wire-textarea>
              </div>
              <div>
                <x-wire-textarea label="Antecedentes Familiares" name="family_history">
                  {{ old('family_history', $patient->family_history) }}
                </x-wire-textarea>
              </div>
            </div>
          </div>

          {{-- Contenido de Tab3: Informacion General --}}
          <div x-show="tab === 'informacion-general'" style="display: none">
              <x-wire-native-select label="Tipo de Sangre" class="mb-4" name="blood_type_id">
                <option value="">Selecciona un tipo de sangre</option>
                @foreach ($bloodTypes as $bloodType)
                  <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id) == $bloodType->id)>
                    {{ $bloodType->name }}
                  </option>
                @endforeach
              </x-wire-native-select>
              <x-wire-textarea label="Observaciones" name="observations">
                {{ old('observations', $patient->observations) }}
              </x-wire-textarea> 
          </div>

          {{-- Contenido de Tab4: Contacto de Emergencia --}}
          <div x-show="tab === 'contacto-emergencia'" style="display: none;">
              <div  class="space-y-4">
                <x-wire-input label="Nombre del Contacto" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />

                <x-wire-phone label="Telefono del Contacto" name="emergency_contact_phone" mask="(###) ###-####" placeholder="(999) 999-9999" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />

                <x-wire-input label="Relacion con el Contacto" name="emergency_contact_relationship" placeholder="Familiar, Pareja, etc." value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" />

              </div>
          </div>

        </div>
      </div>
    </x-wire-card>

  </form>

  
</x-admin-layout>