<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Vendedor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TicketRepository
{
    public function GetAllTickets()
    {
        $tickets = Ticket::where('id', 'vendedor_id')->get();
        return $tickets;
    }
    public function GetUniqueTicket($user_id)
    {
        $ticket = Ticket::find($user_id);

        return $ticket;
    }
    public function getAllVendedor()
    {
        $vendedores = Vendedor::all();
        return $vendedores;
    }

    public function TicketsAtrasados()
    {
        $ticketsQuery = Ticket::with('vendedor');

        $ticketsAtrasados = (clone $ticketsQuery)
            ->where('status', 'Atrasado')
            ->paginate(10);

        $ticketsAtrasadosMaisDe24Horas = (clone $ticketsQuery)
            ->where('status', 'Atrasado')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->paginate(10);

        $todosTickets = $ticketsQuery->paginate(2);

        $noTickets = $todosTickets->isEmpty() && $ticketsAtrasados->isEmpty() && $ticketsAtrasadosMaisDe24Horas->isEmpty();

        return [
            'ticketsAtrasados' => $ticketsAtrasados,
            'ticketsAtrasadosMaisDe24Horas' => $ticketsAtrasadosMaisDe24Horas,
            'todosTickets' => $todosTickets,
            'noTickets' => $noTickets,
        ];
    }

    public function createTicket(array $data)
    {
        DB::beginTransaction();

        try {
            \Log::info('Iniciando criação do ticket.');

            $vendedor = Vendedor::find($data['vendedor_id']);
            \Log::info('Vendedor ID recebido: ' . $data['vendedor_id']);

            if (!$vendedor) {
                throw new \Exception('Vendedor não encontrado no sistema.');
            }

            \Log::info('Vendedor encontrado: ' . $vendedor->id);


            $ticketExistente = Ticket::where('vendedor_id', $vendedor->id)
                ->whereIn('status', ['Aberto', 'Em andamento'])
                ->exists();

            if ($ticketExistente) {
                throw new \Exception('O vendedor já possui um ticket em aberto ou em andamento.');
            }

            \Log::info('Nenhum ticket em aberto encontrado para o vendedor.');


            $suporte = User::role('support')->first();
            if (!$suporte) {
                throw new \Exception('Nenhum suporte disponível para atribuição.');
            }

            \Log::info('Suporte encontrado: ' . $suporte->id);


            $ticket = Ticket::create([
                'assunto' => $data['assunto'],
                'descricao' => $data['descricao'],
                'status' => $data['status'],
                'vendedor_id' => $vendedor->id,
                'suporte_id' => $suporte->id,
            ]);

            \Log::info('Ticket criado com sucesso. ID: ' . $ticket->id);


            $this->atualizarContadoresVendedor($vendedor, $data['status']);

            if ($user->hasRole('vendedor')) {
                $user->notify(new NewTicketNotification($ticket, 'vendedor'));
            } elseif ($user->hasRole('support')) {
                $user->notify(new NewTicketNotification($ticket, 'support'));
            }

            DB::commit();

            return $ticket;

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::error('Erro ao criar ticket: ' . $e->getMessage());
            throw $e;
        }
    }


    public function updateTicket(int $ticketId, array $data)
    {
        DB::beginTransaction();

        try {
            \Log::info('Iniciando atualização do ticket ID: ' . $ticketId);

            $ticket = Ticket::find($ticketId);
            if (!$ticket) {
                throw new \Exception('Ticket não encontrado.');
            }

            \Log::info('Ticket encontrado: ' . $ticket->id);

            if (isset($data['vendedor_id'])) {
                $vendedor = Vendedor::find($data['vendedor_id']);
                if (!$vendedor) {
                    throw new \Exception('Vendedor não encontrado no sistema.');
                }

                \Log::info('Vendedor encontrado: ' . $vendedor->id);

                $ticketExistente = Ticket::where('vendedor_id', $vendedor->id)
                    ->whereIn('status', ['Aberto', 'Em andamento'])
                    ->where('id', '<>', $ticket->id)
                    ->exists();

                if ($ticketExistente) {
                    throw new \Exception('O vendedor já possui um ticket em aberto ou em andamento.');
                }

                \Log::info('Nenhum ticket em aberto encontrado para o vendedor.');
                $ticket->vendedor_id = $vendedor->id;
            }

            if (isset($data['status']) && $ticket->status !== $data['status']) {
                \Log::info('Status do ticket alterado de ' . $ticket->status . ' para ' . $data['status']);
                $this->atualizarContadoresVendedor($ticket->vendedor, $data['status']);
            }

            $ticket->update([
                'assunto' => $data['assunto'] ?? $ticket->assunto,
                'descricao' => $data['descricao'] ?? $ticket->descricao,
                'status' => $data['status'] ?? $ticket->status,
                'suporte_id' => $data['suporte_id'] ?? $ticket->suporte_id,
            ]);

            \Log::info('Ticket atualizado com sucesso. ID: ' . $ticket->id);

            DB::commit();

            return $ticket;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao atualizar ticket: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function atualizarContadoresVendedor($vendedor, $status)
    {

        switch (strtolower($status)) {
            case 'aberto':
                $vendedor->increment('tickets_abertos');
                break;

            case 'em andamento':
                $vendedor->increment('tickets_em_andamento');
                break;

            case 'resolvido':
                $vendedor->increment('tickets_resolvidos');
                break;

            default:

                break;
        }


        $vendedor->save();
    }

    public function getTicketWithRelations($id)
    {
        $ticket = Ticket::with(['vendedor', 'suporte'])->findOrFail($id);

        return $ticket;
    }

    public function getVendedores()
    {
        return Vendedor::all();
    }

    public function getTicketById($id)
    {
        return Ticket::with(['vendedor', 'suporte'])->findOrFail($id);
    }

    public function DeleteTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status = 'resolvido';
        $ticket->save();

        $vendedor = Vendedor::where('user_id', $ticket->user_id)->first();

        if ($vendedor) {
            $this->atualizarContadoresVendedor($vendedor, $ticket->status);
        }

        $ticket->delete();

        return true;
    }

}
