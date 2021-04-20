<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScrappedMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * status
     *
     * @var string
     */
    public $status;

    /**
     * message
     *
     * @var string
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($status, $message)
    {
        $this->message = $message;
        $this->status  = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('scrappedMessage.'.auth()->id());
    }

    /**
     * Handle a job failure.
     *
     * @param Exception $exception
     *
     * @return void
     */
    public function failed(\Throwable $exception)
    {
      \File::append(storage_path('logs') . '/' . basename(get_class($this)) . '.log', $exception->getMessage().PHP_EOL);
    }
}
