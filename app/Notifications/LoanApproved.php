<?php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanApproved extends Notification
{
	use Queueable;

	/**
		* Create a new notification instance.
		*/
	public function __construct(public Book $book)
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
			->subject('Book Loan Approved')
			->greeting('Book Loan Approved')
			->line("Book loan requested for {$this->book->name} has been approved.")
			->action('View Your Loans', url('/loans'))
			->line('Thank you for using being our loyal customer!');
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
