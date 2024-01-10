<?php

namespace App\Notifications;

use App\Models\BookLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class NewLoan extends Notification
{
	use Queueable;

	/**
		* Create a new notification instance.
		*/
	public function __construct(public BookLoan $bookLoan)
	{
		//
	}


	/**
		* Get the notification's delivery channels.
		*
		* @return array<int, string>
		*/
	public function via(object $notifiable): array
	{
		return ['mail'];
	}

	/**
		* Get the mail representation of the notification.
		*/
	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
			->subject("New Book Loan Request")
			->greeting("New Book Loan Request")
			->line("A new book loan request has been made by {$this->bookLoan->user->name}")
			->line("Book: {$this->bookLoan->book->name}")
			->action('View Loan Requests', url('/loans'));
	}

	/**
		* Get the array representation of the notification.
		*
		* @return array<string, mixed>
		*/
	public function toArray(object $notifiable): array
	{
		return [
			//
		];
	}
}
