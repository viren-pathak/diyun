<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Debate;

class DebateInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $inviteUrl;
    public $inviteMessage;
    public $invitedBy;
    public $debate;

    public function __construct($inviteUrl, $inviteMessage, User $invitedBy, Debate $debate)
    {
        $this->inviteUrl = $inviteUrl;
        $this->inviteMessage = $inviteMessage;
        $this->invitedBy = $invitedBy;
        $this->debate = $debate;
    }

    public function build()
    {
        $subject = $this->invitedBy->username . ' has invited you to the discussion “' . $this->debate->title . '”';
        
        return $this->view('emails.debateInvite')
                    ->subject($subject)
                    ->with([
                        'inviteUrl' => $this->inviteUrl,
                        'inviteMessage' => $this->inviteMessage,
                        'invitedBy' => $this->invitedBy,
                        'debate' => $this->debate,
                    ]);
    }
}

