<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuporteController extends Controller
{

    public function index()
    {
        $suportes = User::role('support')->get();
        return view('suporte.index', compact('suportes'));
    }


    public function create()
    {
        return view('suporte.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telefone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'password' => bcrypt($validated['password']),
        ]);


        $user->assignRole('support');

        return redirect()->route('suporte.index')->with('success', 'Suporte cadastrado com sucesso!');
    }


    public function show(User $suporte)
    {
        return view('suporte.show', compact('suporte'));
    }


    public function edit(User $suporte)
    {
        return view('suporte.edit', compact('suporte'));
    }


    public function update(Request $request, User $suporte)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telefone' => 'required|string|max:20',
        ]);

        $suporte->update($validated);

        return redirect()->route('suporte.index')->with('success', 'Suporte atualizado com sucesso!');
    }


    public function destroy(User $suporte)
    {
        $suporte->delete();

        return redirect()->route('suporte.index')->with('success', 'Suporte excluído com sucesso!');
    }
}
