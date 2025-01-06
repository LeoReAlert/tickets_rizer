<x-app-layout>
    <x-slot name="header">
        <h1>Vendedores</h1>
    </x-slot>

    <div class="container mt-5">
        <div class="col-3">
            <form method="GET" action="{{ route('vendedores.index') }}">
                <div class="mb-3">
                    <label for="search" class="form-label">Pesquisar Vendedor:</label>
                    <input type="text" id="search" name="search" class="form-control" value="{{ request()->search }}" placeholder="Pesquisar por nome ou email">
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
  
        <div class="mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tickets Abertos</th>
                        <th>Tickets Em Andamento</th>
                        <th>Tickets Resolvidos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendedores as $vendedor)
                        <tr>
                            <td>{{ $vendedor->nome }}</td>
                            <td>{{ $vendedor->email }}</td>
                            <td>{{ $vendedor->tickets_abertos }}</td>
                            <td>{{ $vendedor->tickets_em_andamento }}</td>
                            <td>{{ $vendedor->tickets_resolvidos }}</td>
                            <td>
                                <a href="{{ route('vendedores.edit', $vendedor) }}" class="btn btn-warning">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $vendedores->links() }}
        </div>
    </div>
</x-app-layout>