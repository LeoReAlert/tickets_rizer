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
        $tickets = Ticket::all();
    }
    public function GetUniqueTicket($user_id)
    {
        $ticket = Ticket::find($user_id);
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
    
        $todosTickets = $ticketsQuery->paginate(10);
    
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
           
            $vendedor = Vendedor::where('user_id', $data['user_id'])->first(); 
    
            if (!$vendedor) {
                throw new \Exception('Vendedor não encontrado no sistema.');
            }
    
     
            $ticketExistente = Ticket::where('vendedor_id', $vendedor->id)
                ->whereIn('status', ['Aberto', 'Em andamento'])
                ->exists();
    
            if ($ticketExistente) {
                throw new \Exception('O vendedor já possui um ticket em aberto ou em andamento.');
            }
    
        
            $suporte = User::role('support')->first();
    
            if (!$suporte) {
                throw new \Exception('Nenhum suporte disponível para atribuição.');
            }
    
            
            $ticket = Ticket::create([
                'assunto' => $data['assunto'],
                'descricao' => $data['descricao'],
                'status' => $data['status'],
                'vendedor_id' => $vendedor->id,  
                'suporte_id' => $suporte->id,    
            ]);
    
        
            $this->atualizarContadoresVendedor($vendedor, $data['status']);
    

            DB::commit();
    
            return $ticket;
        } catch (\Exception $e) {
 
            DB::rollBack();
            \Log::error('Erro ao criar ticket: ' . $e->getMessage());
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
        return User::role('vendedor')->get();
    }

    public function getTicketById($id)
    {
        return Ticket::with(['vendedor', 'suporte'])->findOrFail($id);
    }
}
