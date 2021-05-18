<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
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
     * message
     *
     * @var \App\Models\User
     */
    public $user;


    /**
     * Method __construct
     *
     * @param string $status
     * @param string $message
     * @param \App\Models\User $user
     */
    public function __construct(string $status, string $message, User $user)
    {
        $this->message = $message;
        $this->status  = $status;
        $this->user    = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('scrappedMessage.'.$this->user->id);
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
