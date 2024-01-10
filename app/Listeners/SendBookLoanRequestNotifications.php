<?php

namespace App\Listeners;

use App\Events\BookLoanRequested;
use App\Models\User;
use App\Notifications\NewLoan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookLoanRequestNotifications
{
	/**
		* Create the event listener.
		*/
	public function __construct()
	{
		//
	}

	/**
		* Handle the event.
		*/
	public function handle(BookLoanRequested $event): void
	{

		foreach (User::where('isAdmin', true)->cursor() as $user) {
			$user->notify(new NewLoan($event->bookLoan));
		}
	}
}
