<x-app-layout>
    <x-slot name="header">
        <h1>Editar Ticket</h1>
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
        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="assunto" class="form-label">Assunto</label>
                <input type="text" class="form-control @error('assunto') is-invalid @enderror" id="assunto"
                    name="assunto" value="{{ old('assunto', $ticket->assunto) }}" required>
                @error('assunto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3"
                    required>{{ old('descricao', $ticket->descricao) }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                    required>
                    <option value="Aberto" @if ($ticket->status == 'Aberto') selected @endif>Aberto</option>
                    <option value="Em andamento" @if ($ticket->status == 'Em andamento') selected @endif>Em andamento</option>
                    <option value="Resolvido" @if ($ticket->status == 'Resolvido') selected @endif>Resolvido</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning">Atualizar Ticket</button>
        </form>
    </div>
</x-app-layout>
