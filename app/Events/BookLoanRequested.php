<?php

namespace App\Events;

use App\Models\BookLoan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookLoanRequested
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
		* Create a new event instance.
		*/
	public function __construct(public BookLoan $bookLoan)
	{
		//
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
