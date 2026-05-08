<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $pdfContent)
    {
        $this->appointment = $appointment;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Cita Médica - Healthify',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-created',
            with: [
                'paciente' => $this->appointment->patient->user->name,
                'doctor' => 'Dr(a). ' . $this->appointment->doctor->user->name,
                'fecha' => \Carbon\Carbon::parse($this->appointment->date)->format('d/m/Y'),
                'hora' => \Carbon\Carbon::parse($this->appointment->start_time)->format('H:i'),
                'especialidad' => $this->appointment->doctor->specialty ?? 'Medicina General',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Cita_Medica.pdf')
                    ->withMime('application/pdf'),
        ];
    }
}
