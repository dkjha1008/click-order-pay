<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedVenmo extends Notification
{
    use Queueable;
	public $request;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
		$order = $this->request;
		$url = route('admin.orders.show', $order->id);
		
        return (new MailMessage)
					->greeting('Hello, '. config('app.name'))
                    ->line('A new order #'.$order->id.'  has been placed')
                    ->line('Payment method Venmo')
                    ->line("Customer's Name: ".$order->user->name)
                    ->line("Phone Number: ".$order->user->phone_number)
                    ->line("Address: ".$order->user->address)
                    ->line("Notes: ".$order->user->notes)
                    ->action('Click to View Details', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
