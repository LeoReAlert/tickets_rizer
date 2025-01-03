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
    
        if ($user->hasRole('vendedor') || $user->hasRole('support')) {
            if ($user->hasRole('vendedor')) {
                $ticketsQuery->where('vendedor_id', $user->id);
            }
        } else {
            abort(403, 'Acesso negado');
        }
    
        $ticketsAtrasados = (clone $ticketsQuery)
        ->where('status', 'Atrasado')
        ->get();
    
    
        $todosTickets = $ticketsQuery->get();
    
        if ($ticketsAtrasados->isNotEmpty()) {
            return view('admin.tickets.index', compact('ticketsAtrasados', 'todosTickets'));
        }
    
        if ($todosTickets->isNotEmpty()) {
            return view('admin.tickets.index', compact('todosTickets'));
        }
    
        return view('admin.tickets.index', compact('ticketsAtrasados', 'todosTickets'));
    }
    

    public function create()
    {
        $vendedores = User::role('vendedor')->get();  
        
        return view('admin.tickets.create', compact('vendedores'));
    }
    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string',
            'vendedor_id' => 'required|exists:users,id', 
        ]);
        
       
        $user = User::findOrFail($validated['vendedor_id']);
        
   
        if (!$user->hasRole('vendedor')) {
            return back()->with('error', 'O usuário selecionado não é um vendedor.');
        }
    
       
        $vendedor = Vendedor::where('user_id', $user->id)->first();
        if (!$vendedor) {
            return back()->with('error', 'Vendedor não encontrado no sistema.');
        }
        
        
        $suporte = User::role('support')->first();
        
        if (!$suporte) {
            return back()->with('error', 'Nenhum suporte disponível para atribuição.');
        }
        
    
        $ticket = Ticket::create([
            'assunto' => $validated['assunto'],
            'descricao' => $validated['descricao'],
            'status' => $validated['status'],
            'vendedor_id' => $validated['vendedor_id'], 
            'suporte_id' => $suporte->id, 
        ]);
        
        
        switch ($validated['status']) {
            case 'Aberto':
                $vendedor->increment('tickets_abertos');
                break;
            case 'Em andamento':
                $vendedor->increment('tickets_em_andamento');
                break;
            case 'Resolvido':
                $vendedor->increment('tickets_resolvido');
                break;
        }
    
        return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
    }
    


    public function show(Ticket $ticket)
    {
        $ticket->load('vendedor', 'suporte');
       
        return view('admin.tickets.show', compact('ticket'));
    }
    

    public function edit(Ticket $ticket)
    {
      
        $vendedores = User::role('vendedor')->get();
        return view('admin.tickets.edit', compact('ticket', 'vendedores'));
    }
    

   
    public function update(Request $request, Ticket $ticket)
    {
       
        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string',
            'vendedor_id' => 'required|exists:users,id',
        ]);
        

        $user = User::findOrFail($validated['vendedor_id']);
        
       
        if (!$user->hasRole('vendedor')) {
            return back()->with('error', 'O usuário selecionado não é um vendedor.');
        }
    
       
        $ticket->update([
            'assunto' => $validated['assunto'],
            'descricao' => $validated['descricao'],
            'status' => $validated['status'],
            'vendedor_id' => $validated['vendedor_id'],
        ]);
    
    
        return redirect()->route('tickets.index')->with('success', 'Ticket atualizado com sucesso!');
    }
    
            

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deletado com sucesso!');
    }
}
