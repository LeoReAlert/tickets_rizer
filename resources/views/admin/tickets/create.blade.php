<x-app-layout>
    <x-slot name="header">
        <h1>Criar Ticket</h1>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="assunto" class="form-label">Assunto</label>
                <input type="text" class="form-control @error('assunto') is-invalid @enderror" id="assunto"
                    name="assunto" value="{{ old('assunto') }}" required>
                @error('assunto')
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

            <button type="submit" class="btn btn-primary">Criar Ticket</button>
        </form>
    </div>
</x-app-layout>
