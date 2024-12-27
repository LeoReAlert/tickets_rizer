<x-app-layout>
    <x-slot name="header">
        <h1>Tickets</h1>
    </x-slot>

    <div class="container mt-5">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Criar Ticket</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Assunto</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->assunto }}</td>
                        <td>{{ $ticket->descricao }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Editar</a>

                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
