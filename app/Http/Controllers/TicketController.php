<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use App\Models\User;

class TicketController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $ticketsQuery = Ticket::with('vendedor');

    if ($user->hasRole('vendedor')) {
        $ticketsQuery->where('vendedor_id', $user->id);
    }


    $ticketsAbertosMaisDe24Horas = (clone $ticketsQuery)
        ->where('status', 'aberto')
        ->where('created_at', '<', now()->subHours(24))
        ->exists();


    $ticketsAtrasados = (clone $ticketsQuery)
        ->where('status', 'aberto')
        ->where('created_at', '<', now()->subHours(24))
        ->get();

    $tickets = $ticketsQuery->paginate(3);

    return view('admin.tickets.index', compact('tickets', 'ticketsAbertosMaisDe24Horas', 'ticketsAtrasados'));
}

    public function create()
    {
        $vendedores = Vendedor::where('status', 'Ativo')->get();
        return view('admin.tickets.create', compact('vendedores'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'assunto' => 'required|string|max:255',
        'descricao' => 'required|string',
        'status' => 'required|string',
    ]);


    $suporte = User::role('support')->first();

    if (!$suporte) {
        return back()->with('error', 'Nenhum suporte disponível para atribuição.');
    }


    $ticket = Ticket::create([
        'assunto' => $validated['assunto'],
        'descricao' => $validated['descricao'],
        'status' => $validated['status'],
        'vendedor_id' => auth()->user()->id,
        'suporte_id' => $suporte->id,
    ]);

    return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
}

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $vendedores = Vendedor::where('status', 'Ativo')->get();
        $suportes = User::role('support')->get();
        return view('admin.tickets.edit', compact('ticket', 'vendedores', 'suportes'));
    }

    public function update(Request $request, Ticket $ticket)
    {

    $request->merge([
        'status' => strtolower($request->status),
    ]);

    $validated = $request->validate([
        'assunto' => 'required|string|max:255',
        'descricao' => 'required|string',
        'status' => 'required|string|in:aberto,em andamento,resolvido,atrasado',  // Aceitando minúsculas
        'vendedor_id' => 'required|exists:vendedores,id',
        'suporte_id' => 'nullable|exists:users,id',
    ]);

    $ticket->update($validated);

    return redirect()->route('tickets.index')->with('success', 'Ticket atualizado com sucesso!');
    }


    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deletado com sucesso!');
    }
}
