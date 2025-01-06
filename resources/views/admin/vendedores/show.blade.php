<x-app-layout>
    <x-slot name="header">
        <h1>Detalhes do Vendedor</h1>
    </x-slot>

    <div class="container mt-5">
        <div class="col-3">
      
        </div>

        <div class="mt-4">
            <h3>{{ $vendedor->nome }}</h3>
            <p>Status: {{ $vendedor->status }}</p>

            <h4>Tickets Abertos</h4>
            <ul>
                @forelse ($ticketsAbertos as $ticket)
                    <li>{{ $ticket->id }} - {{ $ticket->descricao }}</li>
                @empty
                    <li>Nenhum ticket aberto encontrado.</li>
                @endforelse
            </ul>

            <h4>Tickets Em Andamento</h4>
            <ul>
                @forelse ($ticketsEmAndamento as $ticket)
                    <li>{{ $ticket->id }} - {{ $ticket->descricao }}</li>
                @empty
                    <li>Nenhum ticket em andamento encontrado.</li>
                @endforelse
            </ul>

            <h4>Tickets Resolvidos</h4>
            <ul>
                @forelse ($ticketsResolvidos as $ticket)
                    <li>{{ $ticket->id }} - {{ $ticket->descricao }}</li>
                @empty
                    <li>Nenhum ticket resolvido encontrado.</li>
                @endforelse
            </ul>


            <div class="mt-3">
  

            </div>
        </div>
    </div>
</x-app-layout>
