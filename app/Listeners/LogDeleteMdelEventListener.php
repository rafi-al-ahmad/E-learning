<?php

namespace App\Listeners;

use App\Events\DeleteModelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogDeleteMdelEventListener
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
     * @param  DeleteModelEvent  $event
     * @return void
     */
    public function handle(DeleteModelEvent $event)
    {
        Log::info("model deleted",['user' => $event->user->_id, 'model' => $event->model, 'request' => $event->request]);
    }
}
