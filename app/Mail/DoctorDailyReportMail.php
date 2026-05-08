<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Doctor;

class DoctorDailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor;
    public $appointments;

    /**
     * Create a new message instance.
     */
    public function __construct(Doctor $doctor, Collection $appointments)
    {
        $this->doctor = $doctor;
        $this->appointments = $appointments;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Agenda de Citas para Hoy - Healthify',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.doctor-daily-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
