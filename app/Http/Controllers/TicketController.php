<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Vendedor;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $vendedores = Vendedor::all();
        return view('admin.tickets.create', compact('vendedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);


        $vendedor = Vendedor::where('status', 'Ativo')
            ->orderByRaw('tickets_abertos + tickets_em_andamento + tickets_resolvidos ASC') // Ordena os vendedores pelo total de tickets
            ->first();

        if ($vendedor) {

            $ticket = Ticket::create([
                'assunto' => $request->assunto,
                'descricao' => $request->descricao,
                'vendedor_id' => $vendedor->id,
                'status' => 'Aberto',
            ]);


            $vendedor->increment('admin.tickets_abertos');


            return redirect()->route('tickets.index')->with('success', 'Ticket criado e atribuído ao vendedor com menos tickets!');
        }

        return back()->with('error', 'Nenhum vendedor ativo disponível para atribuição.');
    }

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $vendedores = Vendedor::all();
        return view('admin.tickets.edit', compact('ticket', 'vendedores'));
    }

    public function update(Request $request, Ticket $ticket)
    {

        $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string|in:Aberto,Em andamento,Resolvido',
            'vendedor_id' => 'required|exists:vendedores,id',
        ]);


        $ticket->update($request->all());


        return redirect()->route('admin.tickets.index')->with('success', 'Ticket atualizado com sucesso!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deletado com sucesso!');
    }
}
