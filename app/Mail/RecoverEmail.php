<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $link;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, User $user)
    {
        $this->link = $link;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['user'] = $this->user;
        $data['link'] = $this->link;
        return $this->view('mail.account_recover', $data);
    }
}
