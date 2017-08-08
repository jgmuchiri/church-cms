<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultMessaging extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('EMAIL_FROM_ADDRESS'))
            ->subject($this->data['subject'])
            ->with(
                [
                    'msg'=>$this->data['message']
                ]
            )
            ->text('emails.messaging_plain')
            ->view('emails.messaging');
    }
}
