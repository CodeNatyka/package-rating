<?php

namespace Natyka\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


// Clase 13: Eventos y Listeners en Laravel
// php artisan make:event ModelRated


class ModelRated
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	private Model $qualifier;
	private Model $rateable;
	private float $score;


	/**
	 * Create a new event instance.
	 */
	public function __construct(Model $qualifier, Model $rateable, float $score)
	{
		$this->qualifier = $qualifier;
		$this->rateable = $rateable;
		$this->score = $score;

		Log::info('ModelRated event fired.', ['qualifier' => $qualifier, 'rateable' => $rateable, 'score' => $score]);
	}


	public function getQualifier(): Model
	{
		return $this->qualifier;
	}

	public function getRateable(): Model
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
