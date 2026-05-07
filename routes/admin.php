<?php

use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
  return view('admin.dashboard');
}) -> name('dashboard');

//Gestion de Roles 
Route::resource('roles', RoleController::class);
//Gestion de Roles 
Route::resource('users', UserController::class);

//Gestion de Roles 
Route::resource('patients', PatientController::class);
Route::resource('doctors', App\Http\Controllers\Admin\DoctorController::class)->except(['create', 'store']);
Route::get('doctors/{doctor}/schedules', App\Livewire\Admin\DoctorScheduleManager::class)->name('doctor-schedules');

Route::get('appointments/create', App\Livewire\Admin\AppointmentCreate::class)->name('appointments.create');
Route::resource('appointments', App\Http\Controllers\Admin\AppointmentController::class)->except(['create']);
Route::get('calendar', [App\Http\Controllers\Admin\CalendarController::class, 'index'])->name('calendar');

Route::get('consultations/{appointment}', App\Livewire\Admin\ConsultationManager::class)->name('consultations.show');