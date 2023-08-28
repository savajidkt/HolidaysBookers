<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RegisterdMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User Model.
     *
     * @var User
     */
    // protected $user;

    /** @var $title */
    protected $title;
    // protected $password;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        // $this->user         = $user;
        // $this->password     = $password;
        $this->data = $data;
        $this->title        = 'Begin Your Relational Intelligence Assessment - Login Credentials';
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
        $data = $this->data;
        return $this
            ->to($data['email'])
            ->subject($this->title)
            ->view('emails.login-credential', [
                'password'     => $data['password'],
                'user'         => $data,
                'url'=>route('login')
            ]);
    }
}
