<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $agentCode;
    protected $email;
    protected $message;
    protected $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agentCode, $email, $attachment_path)
    {
        $this->agentCode = $agentCode;
        $this->email = $email;
        $this->message = 'Holidays Bookers generate voucher and attechment';
        $this->title        = 'Holidays Bookers Generate Voucher';
        $this->attachment        = $attachment_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //echo $this->email; exit;
        return $this
            ->to('jj.parejiya@gmail.com')
            ->subject($this->title)
            ->attach($this->attachment)
            ->view('emails.voucher', [
                'AgentCode'     => $this->agentCode,
                'email'     => $this->email,
                'email_message'     => $this->message
            ]);
    }
}
