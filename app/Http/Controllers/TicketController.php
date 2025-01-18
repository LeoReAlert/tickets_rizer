<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use App\Notifications\NewTicketNotification;
use App\Models\User;
use Carbon\Carbon;

class TicketController extends Controller
{
    private $ticketRepository;

    public function __construct(TicketRepository $TicketRepository)
    {
        $this->TicketRepository = $TicketRepository;
    }
    public function index()
    {
        $user = auth()->user();
    
        $ticketsQuery = $this->TicketRepository->getAllVendedor();
    
        if ($user->hasRole('vendedor') || $user->hasRole('support')) {
            if ($user->hasRole('vendedor')) {
                $ticketsQuery->where('vendedor_id', $user->id);
            }
        } else {
            abort(403, 'Acesso negado');
        }
    
        $ticketsData = $this->TicketRepository->TicketsAtrasados();
    
        $ticketsAtrasados = $ticketsData['ticketsAtrasados'];
        $ticketsAtrasadosMaisDe24Horas = $ticketsData['ticketsAtrasadosMaisDe24Horas'];
        $todosTickets = $ticketsData['todosTickets'];
        $noTickets = $ticketsData['noTickets'];
    
        return view('admin.tickets.index', compact('ticketsAtrasadosMaisDe24Horas', 'ticketsAtrasados', 'todosTickets', 'noTickets'));
    }

    public function create()
    {
        $vendedores = $this->TicketRepository->getAllVendedor();

        return view('admin.tickets.create', compact('vendedores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string|in:Aberto,Em andamento,Atrasado,Resolvido',
            'vendedor_id' => 'required|exists:vendedores,user_id', 
        ]);
    
        try {
        
            $ticket = $this->TicketRepository->createTicket([
                'assunto' => $validated['assunto'],
                'descricao' => $validated['descricao'],
                'status' => $validated['status'],
                'vendedor_id' => $validated['vendedor_id'], 
            ]);
    
            if ($ticket) {
                $supportUsers = User::role('support')->get();
                foreach ($supportUsers as $user) {
                    $user->notify(new NewTicketNotification($ticket));
                }
    
                return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso e notificação enviada!');
            }
    
            return back()->with('error', 'Ocorreu um erro ao criar o ticket.');
    
        } catch (\Exception $e) {
            \Log::error('Erro ao criar ticket: ' . $e->getMessage());
            return back()->with('error', 'Erro ao criar o ticket: ' . $e->getMessage());
        }
    }
    


    public function show($id)
    {
        try {
            $ticket = $this->TicketRepository->getTicketWithRelations($id);

            if (!auth()->user()->can('view', $ticket)) {
                abort(403, 'Você não tem permissão para visualizar este ticket.');
            }
            return view('admin.tickets.show', compact('ticket'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $ticket = $this->TicketRepository->getTicketById($id);

            $vendedores = $this->TicketRepository->getVendedores();

            return view('admin.tickets.edit', compact('ticket', 'vendedores'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string|in:Aberto,Em andamento,Atrasado,Resolvido',
            'vendedor_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['vendedor_id']);


        if (!$user->hasRole('vendedor')) {
            return back()->with('error', 'O usuário selecionado não é um vendedor.');
        }


        $oldStatus = $ticket->status;


        $ticket->update([
            'assunto' => $validated['assunto'],
            'descricao' => $validated['descricao'],
            'status' => $validated['status'],
            'vendedor_id' => $validated['vendedor_id'],
        ]);


        $vendedor = $user->vendedor;


        if ($validated['status'] == 'Aberto') {
            $vendedor->tickets_abertos += 1;
        } elseif ($validated['status'] == 'Em andamento') {
            $vendedor->tickets_em_andamento += 1;
        } elseif ($validated['status'] == 'Resolvido') {
            $vendedor->tickets_resolvidos += 1;
        }


        if ($oldStatus == 'Aberto') {
            $vendedor->tickets_abertos = max(0, $vendedor->tickets_abertos - 1);
        } elseif ($oldStatus == 'Em andamento') {
            $vendedor->tickets_em_andamento = max(0, $vendedor->tickets_em_andamento - 1);
        } elseif ($oldStatus == 'Resolvido') {
            $vendedor->tickets_resolvidos = max(0, $vendedor->tickets_resolvidos - 1);
        }


        $vendedor->save();


        return redirect()->route('tickets.index')->with('success', 'Ticket atualizado com sucesso!');
    }


    public function destroy(Ticket $ticket)
    {


        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deletado com sucesso!');
    }


}
