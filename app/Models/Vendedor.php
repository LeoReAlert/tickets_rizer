<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'telefone', 'status', 'tickets_abertos', 'tickets_em_andamento', 'tickets_resolvidos'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public function ticketsAbertos()
    {
        return $this->hasMany(Ticket::class)->where('status', 'Aberto');
    }


    public function ticketsEmAndamento()
    {
        return $this->hasMany(Ticket::class)->where('status', 'Em andamento');
    }


    public function ticketsResolvidos()
    {
        return $this->hasMany(Ticket::class)->where('status', 'Resolvido');
    }


    public function getQuantidadeTicketsPorStatus($status)
    {
        return $this->tickets()->where('status', $status)->count();
    }

    public function getQuantidadeTicketsAbertos()
    {
        return $this->getQuantidadeTicketsPorStatus('Aberto');
    }

    public function getQuantidadeTicketsEmAndamento()
    {
        return $this->getQuantidadeTicketsPorStatus('Em andamento');
    }

    public function getQuantidadeTicketsResolvidos()
    {
        return $this->getQuantidadeTicketsPorStatus('Resolvido');
    }
}
