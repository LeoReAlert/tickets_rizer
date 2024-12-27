<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use App\Models\Ticket;
use Illuminate\Http\Request;

class VendedorController extends Controller
{

    public function index()
    {
        $vendedores = Vendedor::all();
        return view('vendedores.index', compact('vendedores'));
    }


    public function create()
    {
        return view('vendedores.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:vendedores,email',
            'telefone' => 'required|string|max:15',
            'status' => 'required|string|max:15',
        ]);


        $vendedor = Vendedor::create($request->all());


        $vendedor->assignRole('vendedor');

        return redirect()->route('vendedores.index')->with('success', 'Vendedor criado com sucesso!');
    }


    public function show(Vendedor $vendedor)
    {
        $ticketsAbertos = $vendedor->ticketsAbertos;
        $ticketsEmAndamento = $vendedor->ticketsEmAndamento;
        $ticketsResolvidos = $vendedor->ticketsResolvidos;

        return view('vendedores.show', compact('vendedor', 'ticketsAbertos', 'ticketsEmAndamento', 'ticketsResolvidos'));
    }


    public function edit(Vendedor $vendedor)
    {
        return view('vendedores.edit', compact('vendedor'));
    }


    public function update(Request $request, Vendedor $vendedor)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:vendedores,email,' . $vendedor->id,
            'telefone' => 'required|string|max:15',
            'status' => 'required|string|max:15',
        ]);

        $vendedor->update($request->all());

        return redirect()->route('vendedores.index')->with('success', 'Vendedor atualizado com sucesso!');
    }


    public function destroy(Vendedor $vendedor)
    {
        $vendedor->delete();

        return redirect()->route('vendedores.index')->with('success', 'Vendedor deletado com sucesso!');
    }
}
