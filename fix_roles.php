<?php

use App\Models\Doctor;
use App\Models\Patient;
use Spatie\Permission\Models\Role;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
$patientRole = Role::firstOrCreate(['name' => 'Paciente']);

foreach(Doctor::all() as $doctor) {
    if ($doctor->user) {
        $doctor->user->assignRole($doctorRole);
    }
}

foreach(Patient::all() as $patient) {
    if ($patient->user) {
        $patient->user->assignRole($patientRole);
    }
}

echo "Roles assigned successfully!\n";
