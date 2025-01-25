<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $recipientType;

    /**
     * Create a new notification instance.
     *
     * @param mixed $ticket
     * @param string $recipientType ('vendedor' ou 'suporte')
     */
    public function __construct($ticket, $role)
    {
        $this->ticket = $ticket;
        $this->role = $role;
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
        $mail = new MailMessage;

        if ($notifiable->hasRole('vendedor')) {
            $mail->subject('Novo Ticket Criado')
                 ->greeting('Olá, ' . $notifiable->name . '!')
                 ->line('Seu ticket foi criado com sucesso e contém os seguintes detalhes:')
                 ->line('**Assunto:** ' . $this->ticket->assunto)
                 ->line('**Descrição:** ' . $this->ticket->descricao)
                 ->line('**Status:** ' . $this->ticket->status)
                 ->action('Visualizar Ticket', url('/tickets/' . $this->ticket->id))
                 ->line('Obrigado por usar nosso sistema. Estamos à disposição para ajudá-lo!');
        } elseif ($notifiable->hasRole('support')) {
            $mail->subject('Novo Ticket Atribuído a Você')
                 ->greeting('Olá, ' . $notifiable->name . '!')
                 ->line('Um novo ticket foi atribuído a você. Confira os detalhes abaixo:')
                 ->line('**Assunto:** ' . $this->ticket->assunto)
                 ->line('**Descrição:** ' . $this->ticket->descricao)
                 ->line('**Status:** ' . $this->ticket->status)
                 ->action('Gerenciar Ticket', url('/tickets/' . $this->ticket->id))
                 ->line('Agradecemos pela sua dedicação e prontidão em resolver este ticket.');
        }
        

        return $mail->line('Obrigado por usar nossa aplicação!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'assunto' => $this->ticket->assunto,
            'descricao' => $this->ticket->descricao,
        ];
    }
}
