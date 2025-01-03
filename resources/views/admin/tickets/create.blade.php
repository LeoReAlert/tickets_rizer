<x-app-layout>
    <x-slot name="header">
        <h1>Criar Ticket</h1>
    </x-slot>

    @if (session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

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

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                    required>
                    <option value="">Selecione o status</option>
                    <option value="Aberto" {{ old('status') == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                    <option value="Em andamento" {{ old('status') == 'Em andamento' ? 'selected' : '' }}>Em Andamento
                    </option>
                    <option value="Atrasado" {{ old('status') == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
                    <option value="Resolvido" {{ old('status') == 'Resolvido' ? 'selected' : '' }}>Resolvido</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="vendedor_id" class="form-label">Vendedor</label>
                <select class="form-control @error('vendedor_id') is-invalid @enderror" id="vendedor_id" name="vendedor_id" required>
                    <option value="">Selecione o vendedor</option>
                    @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" class="text-dark" {{ old('vendedor_id') == $vendedor->id ? 'selected' : '' }}>
                            {{ $vendedor->name }}
                        </option>
                    @endforeach
                </select>
                @error('vendedor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Criar Ticket</button>
        </form>
    </div>
</x-app-layout>
