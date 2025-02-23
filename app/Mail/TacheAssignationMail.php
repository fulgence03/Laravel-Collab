<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Tache;
use App\Models\User;
class TacheAssignationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $tache;
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct(Tache $tache, User $user)
    {
        $this->tache = $tache;
        $this->user = $user;
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle Tâche',
        );
    }

    /**
     * Get the message content definition.
     */
    /**public function content(): Content
    {
        return new Content(
            view: 'mails.tache_assignation')

    }**/

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
            ->view('emails.tache_assignation')
            ->with([
                'tache' => $this->tache,
                'user' => $this->user
            ]);
    }
}
