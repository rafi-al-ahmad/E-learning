<?php

namespace App\Listeners;

use App\Events\ActivateAccount;
use App\Jobs\SendMail;
use App\Mail\ActivateAccountMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendActivateAccountNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActivateAccount  $event
     * @return void
     */
    public function handle(ActivateAccount $event)
    {
        //
        $user = $event->user;
        dispatch(new SendMail($user->email, new ActivateAccountMail()));

    }
}
