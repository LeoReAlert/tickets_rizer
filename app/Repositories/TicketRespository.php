<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository{
    public function GetAllTickets(){
           $tickets = Ticket::all();
    }
    public function GetUniqueTicket($user_id){
        $ticket = Ticket::find($user_id);
    }
}
