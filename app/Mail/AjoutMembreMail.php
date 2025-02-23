<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use App\Models\Projet;
use App\Models\User;
class AjoutMembreMail extends Mailable
{
    use Queueable, SerializesModels;
    public $projet;
    public $user;

    public $admin;
    /**
     * Create a new message instance.
     */
    public function __construct(Projet $projet, User $user, User $admin)
    {
        //
        $this->projet = $projet;
        $this->user = $user;
        $this->admin = $admin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau Projet',
        );
    }

    /**
     * Get the message content definition.
     */
    /*public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Assignation de tâche')
            ->view('emails.ajout_membre')
            ->with([
                'projet' => $this->projet,
                'user' => $this->user,
                'admin' => $this->admin
            ]);
    }
}
