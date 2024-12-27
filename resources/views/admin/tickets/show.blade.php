<x-app-layout>
    <x-slot name="header">
        <h1>Detalhes do Ticket</h1>
    </x-slot>

    <div class="container mt-5">
        <h3>{{ $ticket->assunto }}</h3>
        <p>{{ $ticket->descricao }}</p>
        <p>Status: {{ $ticket->status }}</p>
        <p>Vendedor: {{ $ticket->vendedor->nome }}</p>

        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</x-app-layout>
