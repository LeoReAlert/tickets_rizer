<x-app-layout>
    <x-slot name="header">
        <h1>Detalhes do Ticket</h1>
    </x-slot>

    <div class="container mb-5 mt-5">

        <h3>{{ $ticket->assunto }}</h3>
        <p><strong>Descrição:</strong> {{ $ticket->descricao }}</p>


        <p><strong>Status:</strong>
            @if ($ticket->status == 'Atrasado')
                <span class="text-danger">{{ $ticket->status }}</span>
            @elseif($ticket->status == 'Resolvido')
                <span class="text-success">{{ $ticket->status }}</span>
            @elseif($ticket->status == 'Em andamento')
                <span class="text-warning">{{ $ticket->status }}</span>
            @else
                <span class="text-primary">{{ $ticket->status }}</span>
            @endif
        </p>


        <p><strong>Vendedor:</strong>
            @if ($ticket->vendedor)
                {{ $ticket->vendedor->name }}
            @else
                Vendedor não atribuído
            @endif
        </p>

        <p><strong>Suporte:</strong>
            @if ($ticket->suporte)
                {{ $ticket->suporte->name }}
            @else
                Suporte não atribuído
            @endif
        </p>



        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</x-app-layout>
