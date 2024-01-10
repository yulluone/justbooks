<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUser extends Notification
{
	use Queueable;

	/**
		* Create a new notification instance.
		*/
	public function __construct()
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
			->subject('Welcome to JustBooks')
			->greeting('Welcome to JustBooks')
			->line('Congratulations! You have been given access to JustBooks.')
			->line("Use your email address to reset your password and dive into the adventure of a lifetime.")
			->action('Reset Password', url('/forgot-password'));
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
