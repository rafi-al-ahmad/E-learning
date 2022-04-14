<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;

class UpdateModelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user  ;
    public $model  ;
    public $request  ;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Model $model, Request $request)
    {
        $this->user = $user;
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
