<x-app-layout>
    <x-slot name="header">
        <h1>Tickets</h1>
    </x-slot>
    <div class="container mb-2 mt-5">
        <!-- Exibindo alerta para tickets atrasados -->
        @if ($ticketsAtrasados->isNotEmpty())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Atenção!</strong> Existem tickets com status "Atrasado" que precisam ser resolvidos
                imediatamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($noTickets)
            <div class="alert alert-warning">
                Não há tickets cadastrados no sistema.
            </div>
        @endif

        <!-- Exibindo alerta para tickets com mais de 24 horas -->
        @if ($ticketsAtrasadosMaisDe24Horas->isNotEmpty())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Atenção!</strong> Existem tickets com mais de 24 horas que precisam ser resolvidos
                imediatamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Exibindo Todos os Tickets -->
        <div class="container mt-5">
            <!-- Botão de criação de Ticket -->
            <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-5">Criar Ticket</a>

            <!-- Exibindo Todos os Tickets -->
            @if ($todosTickets->isNotEmpty())
                <h2>Todos os Tickets</h2>
                <table class="mt-4 table">
                    <thead>
                        <tr>
                            <th>Assunto</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Vendedor</th>
                            <th>Suporte</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todosTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->created_at->format('Y/d') }}</td>
                                <td>{{ $ticket->descricao }}</td>
                                <td>{{ $ticket->status }}</td>
                                <td>{{ $ticket->vendedor->nome ?? 'Vendedor não atribuído' }}</td>
                                <td>{{ $ticket->suporte->name ?? 'Suporte não atribuído' }}</td>
                                <td>
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info">Ver</a>
                                    @role('support')
                                        <a href="{{ route('tickets.edit', $ticket->id) }}"
                                            class="btn btn-warning">Editar</a>
                                    @endrole
                                    @role('support')
                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Deletar</button>
                                        </form>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Paginação para Todos os Tickets -->
                {{ $todosTickets->links() }}
            @endif
        </div>
    </div>
</x-app-layout>
