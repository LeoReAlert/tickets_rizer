<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Vendedor;

class TicketRepository
{
    public function GetAllTickets()
    {
        $tickets = Ticket::all();
    }
    public function GetUniqueTicket($user_id)
    {
        $ticket = Ticket::find($user_id);
    }
    public function getAllVendedor()
    {
        $ticketsQuery = Ticket::with('vendedor');
    }

    public function TicketsAtrasados(){

        $ticketsQuery = Ticket::with('vendedor');

        $ticketsAtrasados = (clone $ticketsQuery)
        ->where('status', 'Atrasado')
        ->paginate(10);

        $ticketsAtrasadosMaisDe24Horas = (clone $ticketsQuery)
        ->where('status', 'Atrasado')
        ->where('created_at', '<', Carbon::now()->subHours(24))
        ->paginate(10);

        $todosTickets = $ticketsQuery->paginate(10);

        $noTickets = $todosTickets->isEmpty() && $ticketsAtrasados->isEmpty() && $ticketsAtrasadosMaisDe24Horas->isEmpty();

        return [
            'ticketsAtrasados' => $ticketsAtrasados,
            'ticketsAtrasadosMaisDe24Horas' => $ticketsAtrasadosMaisDe24Horas,
            'todosTickets' => $todosTickets,
            'noTickets' => $noTickets,
        ];
    }


}
