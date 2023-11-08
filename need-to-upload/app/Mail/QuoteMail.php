<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paramArr)
    {
        $this->data = $paramArr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        return $this->view('emails.quote', ['data' => $this->data ])
            ->subject($this->data['subject'])
            ->attach($this->data['fileName']);
    }
}
