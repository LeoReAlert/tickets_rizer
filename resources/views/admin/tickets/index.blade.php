<x-app-layout>
    <x-slot name="header">
        <h1>Tickets</h1>
    </x-slot>

  @if (isset($ticketsAtrasados) && $ticketsAtrasados->isNotEmpty())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Atenção!</strong> Existem tickets com status "Atrasado" que precisam ser resolvidos imediatamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    @if (isset($todosTickets) && $todosTickets->isEmpty())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Info!</strong> Não há tickets cadastrados no momento.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-5">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Criar Ticket</a>

        @if (isset($ticketsAtrasados) && $ticketsAtrasados->isNotEmpty())
            <h2>Tickets Atrasados</h2>
            <table class="table mt-4">
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
                    @foreach ($ticketsAtrasados as $ticket)
                        <tr>
                            <td>{{ $ticket->created_at->format('Y/d') }}</td>
                            <td>{{ $ticket->descricao }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td>{{ $ticket->vendedor->name ?? 'Vendedor não atribuído' }}</td>
                            <td>{{ $ticket->suporte->name ?? 'Suporte não atribuído' }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info">Ver</a>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Editar</a>
                                @role('support')
                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="d-inline">
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
        @endif

        @if (isset($todosTickets) && $todosTickets->isNotEmpty())
            <h2>Todos os Tickets</h2>
            <table class="table mt-4">
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
                            <td>{{ $ticket->vendedor->name ?? 'Vendedor não atribuído' }}</td>
                            <td>{{ $ticket->suporte->name ?? 'Suporte não atribuído' }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info">Ver</a>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Editar</a>
                                @role('support')
                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="d-inline">
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
        @endif
    </div>
</x-app-layout>
