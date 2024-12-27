<x-app-layout>
    <x-slot name="header">
        <h1>Cadastro de Ticket</h1>
    </x-slot>

    <div class="container">
        <h2>Formulário de Cadastro de Ticket</h2>

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                    name="titulo" value="{{ old('titulo') }}" required>
                @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3"
                    required>{{ old('descricao') }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="vendedor_id" class="form-label">Vendedor</label>
                <select class="form-select @error('vendedor_id') is-invalid @enderror" id="vendedor_id"
                    name="vendedor_id" required>
                    <option value="">Selecione um Vendedor</option>
                    @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" {{ old('vendedor_id') == $vendedor->id ? 'selected' : '' }}>
                            {{ $vendedor->nome }}</option>
                    @endforeach
                </select>
                @error('vendedor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                    required>
                    <option value="Aberto" {{ old('status') == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                    <option value="Em Andamento" {{ old('status') == 'Em Andamento' ? 'selected' : '' }}>Em Andamento
                    </option>
                    <option value="Resolvido" {{ old('status') == 'Resolvido' ? 'selected' : '' }}>Resolvido</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Ticket</button>
        </form>
    </div>
</x-app-layout>
