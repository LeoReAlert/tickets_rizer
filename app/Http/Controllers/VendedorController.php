<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class VendedorController extends Controller
{
    public function index()
    {
        $vendedores = Vendedor::paginate(10);
        return view('admin.vendedores.index', compact('vendedores'));
    }
    

    public function create()
    {
        $users = User::all();
        return view('admin.vendedores.create', compact('users'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefone' => 'required|string|max:15|unique:vendedores,telefone',
            'status' => 'required|string|in:Ativo,Inativo',
            'senha' => 'required|string|min:8|confirmed',
        ]);
    
    
        $user = User::create([
            'name' => $validated['nome'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['senha']),
        ]);
    
        
        $role = Role::findByName('vendedor');
        $user->assignRole($role);
    
    
        $vendedor = Vendedor::create([
            'user_id' => $user->id,   
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'status' => $validated['status'],
        ]);
    
    
        return redirect()->route('vendedores.index')->with('success', 'Vendedor criado com sucesso!');
    }
    

    public function show(Vendedor $vendedor)
    {
        $ticketsAbertos = $vendedor->ticketsAbertos()->count();
        $ticketsEmAndamento = $vendedor->ticketsEmAndamento()->count();
        $ticketsResolvidos = $vendedor->ticketsResolvidos()->count();

        return view('admin.vendedores.show', compact('vendedor', 'ticketsAbertos', 'ticketsEmAndamento', 'ticketsResolvidos'));
    }

    public function edit(Vendedor $vendedor)
    {
        return view('admin.vendedores.edit', compact('vendedor'));
    }

    public function update(Request $request, Vendedor $vendedor)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:vendedores,email,' . $vendedor->id,
            'telefone' => 'required|string|max:15',
            'status' => 'required|string|in:Ativo,Inativo',
        ], [
            'user_id.required' => 'O campo usuário é obrigatório.',
            'user_id.exists' => 'Usuário não encontrado.',
            'nome.required' => 'O campo nome é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'status.in' => 'O status deve ser Ativo ou Inativo.',
        ]);

        $vendedor->update($request->all());

        return redirect()->route('admin.vendedores.index')->with('success', 'Vendedor atualizado com sucesso!');
    }

    public function destroy(Vendedor $vendedor)
    {
        try {
            $vendedor->delete();
            return redirect()->route('admin.vendedores.index')->with('success', 'Vendedor deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.vendedores.index')->with('error', 'Erro ao deletar vendedor: ' . $e->getMessage());
        }
    }
}
