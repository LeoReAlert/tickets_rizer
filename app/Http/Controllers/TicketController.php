<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use Illuminate\Http\Request;
use App\Repositories\VendedorRepository;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    protected $ticketRepository;
    protected $vendedorRepository;

    public function __construct(TicketRepository $ticketRepository, VendedorRepository $vendedorRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->vendedorRepository = $vendedorRepository;
    }
    public function index()
    {
        $user = auth()->user();

        $ticketsQuery = $this->ticketRepository->getAllVendedor();
        $ticketsData = $this->ticketRepository->TicketsAtrasados();


        $ticketsAtrasados = $ticketsData['ticketsAtrasados'];
        $ticketsAtrasadosMaisDe24Horas = $ticketsData['ticketsAtrasadosMaisDe24Horas'];
        $todosTickets = $ticketsData['todosTickets'];
        $noTickets = $ticketsData['noTickets'];


        return view('admin.tickets.index', compact(
            'ticketsAtrasadosMaisDe24Horas',
            'ticketsAtrasados',
            'todosTickets',
            'noTickets'
        ));
    }


    public function create()
    {
        $vendedores = $this->ticketRepository->getAllVendedor();

        return view('admin.tickets.create', compact('vendedores'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string|in:Aberto,Em andamento,Atrasado,Resolvido',
            'vendedor_id' => 'required|exists:vendedores,id',
        ]);

        try {

            $ticket = $this->ticketRepository->createTicket([
                'assunto' => $validated['assunto'],
                'descricao' => $validated['descricao'],
                'status' => $validated['status'],
                'vendedor_id' => $validated['vendedor_id'],
            ]);


            if ($ticket) {
                return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
            }

            return redirect()->route('tickets.index')->with('error', 'Ocorreu um erro ao criar o ticket.');

        } catch (\Exception $e) {
            \Log::error('Erro ao criar ticket: ' . $e->getMessage());
            return redirect()->route('tickets.index')->with('error', 'Erro ao criar o ticket: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $ticket = $this->ticketRepository->getTicketWithRelations($id);

            return view('admin.tickets.show', compact('ticket'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {

        try {
            $ticket = $this->ticketRepository->getTicketById($id);

            $vendedores = $this->ticketRepository->getVendedores();

            return view('admin.tickets.edit', compact('ticket', 'vendedores'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string|in:Aberto,Em andamento,Atrasado,Resolvido',
            'vendedor_id' => 'required|exists:vendedores,id',
        ]);

        try {

            $ticket = $this->ticketRepository->updateTicket($id, $validated);

            return redirect()->route('tickets.index')->with('success', 'Ticket atualizado com sucesso.');
        } catch (\Exception $e) {

            \Log::error('Erro ao atualizar ticket ID ' . $id . ': ' . $e->getMessage());

            return redirect()->back()->with('error', 'Erro ao atualizar o ticket.');
        }
    }

    public function destroy($id)
    {
        $this->ticketRepository->DeleteTicket($id);

        return redirect()->route('tickets.index')->with('success', 'Ticket deletado com sucesso!');
    }
}
