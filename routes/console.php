<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Programar el envío de reportes de citas todos los días a las 11:58 AM (o la hora ajustada por el usuario)
Schedule::command('appointments:send-daily-reports')->dailyAt('11:58');

// Programar recordatorios por WhatsApp 2 días antes de la cita a las 12:25 PM
Schedule::command('appointments:send-whatsapp-reminders')->dailyAt('12:36');
