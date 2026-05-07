<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DoctorPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'Paciente']);

        // Crear 10 Doctores
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Doctor Demo $i",
                'email' => "doctor{$i}@demo.com",
                'password' => Hash::make('password'),
                'id_number' => "5000000" . $i,
                'phone' => "60000000" . $i,
                'address' => 'Dirección de prueba',
            ]);

            $user->assignRole($doctorRole);

            $specialties = ['Cardiología', 'Dermatología', 'Endocrinología', 'Ginecología', 'Geriatría', 'Hematología'];
            
            Doctor::create([
                'user_id' => $user->id,
                'specialty' => $specialties[array_rand($specialties)],
                'license_number' => "MED-" . rand(1000, 9999),
            ]);
        }

        // Crear 20 Pacientes
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => "Paciente Demo $i",
                'email' => "paciente{$i}@demo.com",
                'password' => Hash::make('password'),
                'id_number' => "7000000" . str_pad($i, 2, '0', STR_PAD_LEFT),
                'phone' => "90000000" . str_pad($i, 2, '0', STR_PAD_LEFT),
                'address' => 'Dirección de prueba',
            ]);

            $user->assignRole($patientRole);

            Patient::create([
                'user_id' => $user->id,
                'blood_type_id' => rand(1, 8), // Asumiendo que hay 8 tipos de sangre
                'allergies' => $i % 3 == 0 ? 'Polen, Penicilina' : null,
                'chronic_conditions' => $i % 5 == 0 ? 'Hipertensión' : null,
            ]);
        }
    }
}
