<x-app-layout>
    <x-slot name="header">
        <h1>Vendedores e seus Tickets</h1>
    </x-slot>

    <div class="container mt-5">
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th>Tickets</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendedores as $vendedor)
                    <tr>
                        <td>{{ $vendedor->nome }}</td>
                        <td>{{ $vendedor->email }}</td>
                        <td>{{ $vendedor->status }}</td>
                        <td>
                            @if ($vendedor->tickets_count == 0)
                                Nenhum ticket associado
                            @else
                                {{ $vendedor->tickets_count }} ticket(s) associado(s)
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $vendedores->links() }}
    </div>
</x-app-layout>
