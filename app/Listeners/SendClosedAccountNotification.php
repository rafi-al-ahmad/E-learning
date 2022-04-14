<?php

namespace App\Listeners;

use App\Events\CloseAccount;
use App\Jobs\SendMail;
use App\Mail\ClosedAccountMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendClosedAccountNotification
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
     * @param  CloseAccount  $event
     * @return void
     */
    public function handle(CloseAccount $event)
    {
        $user = $event->user;
        dispatch(new SendMail($user->email, new ClosedAccountMail()));
    }
}
