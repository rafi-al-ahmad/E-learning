<?php

namespace App\Listeners;

use App\Events\UpdateModelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUpdateMdelEventListener
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
     * @param  UpdateModelEvent  $event
     * @return void
     */
    public function handle(UpdateModelEvent $event)
    {
        Log::info("model updated",['user' => $event->user->_id, 'model' => $event->model->_id, 'request' => $event->request]);
    }
}
