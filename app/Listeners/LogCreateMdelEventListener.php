<?php

namespace App\Listeners;

use App\Events\CreateModelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogCreateMdelEventListener
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
     * @param  CreateModelEvent  $event
     * @return void
     */
    public function handle(CreateModelEvent $event)
    {
        Log::info("model created",['user' => $event->user->_id, 'model' => $event->model->_id, 'request' => $event->request]);
    }
}
