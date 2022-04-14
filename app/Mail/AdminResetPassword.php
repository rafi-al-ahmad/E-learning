<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData=[])
    {

        $this->mailData = $mailData;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $this->mailData = json_encode($this->mailData);

        $url =  AdminUrl('password/reset/'.$this->mailData['token'].'?email='.$this->mailData['admin']->email);
        $this->mailData['url'] = $url;
        return $this->markdown('admin.emails.AdminResetPassword')
        ->subject('Reset Password Notification')
        ->with('data', $this->mailData);
    }
}
