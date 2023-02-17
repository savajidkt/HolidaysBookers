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
    protected $user;

    /** @var $title */
    protected $title;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password,User $user)
    {
        $this->user         = $user;
        $this->password     = $password;
        $this->title        = 'Begin Your Relational Intelligence Assessment - Login Credentials';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this
            ->to($this->user->email)
            ->subject($this->title)
            ->view('emails.login-credential', [
                'password'     => $this->password,
                'user'         => $this->user,
                'url'=>route('login')
            ]);
    }
}
