<?php

namespace Natyka\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Natyka\Contracts\Qualifier;
use Natyka\Contracts\Rateable;

// Clase 13: Eventos y Listeners en Laravel
// php artisan make:event ModelRated

class ModelRated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Qualifier $qualifier;

    private Rateable $rateable;

    private float $score;

    /**
     * Create a new event instance.
     */
    public function __construct(Qualifier $qualifier, Rateable $rateable, float $score)
    {
        $this->qualifier = $qualifier;
        $this->rateable = $rateable;
        $this->score = $score;

        Log::info('ModelRated event fired.', ['qualifier' => $qualifier, 'rateable' => $rateable, 'score' => $score]);
    }

    public function getQualifier(): Qualifier
    {
        return $this->qualifier;
    }

    public function getRateable(): Rateable
    {
        return $this->rateable;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
