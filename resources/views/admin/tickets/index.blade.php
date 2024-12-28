<x-app-layout>
    <x-slot name="header">
        <h1>Tickets</h1>
    </x-slot>

    <!-- Alerta para tickets abertos há mais de 24 horas -->
    @if ($ticketsAbertosMaisDe24Horas)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atenção!</strong> Existem tickets abertos há mais de 24 horas que requerem atenção.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-5">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Criar Ticket</a>

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
                @foreach ($tickets as $ticket)
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
        {{ $tickets->links() }}
    </div>
</x-app-layout>
