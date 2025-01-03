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
                    <th>Data</th>
                    <th>Tickets Abertos</th>
                    <th>Tickets em Andamento</th>
                    <th>Tickets Resolvidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendedores as $vendedor)
                    <tr>
                        <td>{{ $vendedor->nome }}</td>
                        <td>{{ $vendedor->email }}</td>
                        <td>{{ $vendedor->status }}</td>
                        <td> {{$vendedor->created_at->format('y-d')}} </td>
                        <td>{{ $vendedor->tickets_abertos }}</td>
                        <td>{{ $vendedor->tickets_em_andamento }}</td>
                        <td>{{ $vendedor->tickets_resolvido }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginação -->
        {{ $vendedores->links() }}
    </div>
</x-app-layout>
