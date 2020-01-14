<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailBuilder extends Mailable
{
    use Queueable, SerializesModels;

    protected $messageData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject('Message From Contact Page');
        return $this->view('email.contactMessage')
            ->with(
                [
                    'firstName' =>  $this->messageData['firstName'],
                    'lastName' =>  $this->messageData['lastName'],
                    'email' =>  $this->messageData['email'],
                    'phone' =>  $this->messageData['phone'],
                    'sender_message' =>  $this->messageData['message'],
                ]
            );
    }
}
