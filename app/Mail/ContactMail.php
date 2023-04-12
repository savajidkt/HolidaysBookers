<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $fullname;
    protected $email;
    protected $contactNumber;
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname,$email, $contactNumber, $message)
    {
        $this->fullname = $fullname;
        $this->email = $email;
        $this->contactNumber = $contactNumber;
        $this->message = $message;
        $this->title        = 'Holidays Bookers Contact Us';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        
        return $this
            ->to(env('ADMIN_EMAIL'))
            ->subject($this->title)
            ->view('emails.contact-us', [
                'fullname'     => $this->fullname,
                'email'     => $this->email,
                'contactNumber'     => $this->contactNumber,
                'email_message'     => $this->message                
            ]);
    }
}
