<x-app-layout>
    <x-slot name="header">
        <h1>Editar Ticket</h1>
    </x-slot>
    <div class="container mb-5 mt-5">
        @if (session('success'))
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
                <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
                <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        <div class="container mb-5 mt-5">
            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                @method('PUT')
                @csrf

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
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="">Selecione o status</option>
                        <option value="Aberto" {{ old('status', $ticket->status) == 'Aberto' ? 'selected' : '' }}>Aberto
                        </option>
                        <option value="Em andamento"
                            {{ old('status', $ticket->status) == 'Em andamento' ? 'selected' : '' }}>Em Andamento
                        </option>
                        <option value="Atrasado" {{ old('status', $ticket->status) == 'Atrasado' ? 'selected' : '' }}>
                            Atrasado</option>
                        <option value="Resolvido"
                            {{ old('status', $ticket->status) == 'Resolvido' ? 'selected' : '' }}>
                            Resolvido</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <input type="hidden" name="vendedor_id" value="{{ $ticket->vendedor->id }}">
                <div class="mb-3">
                    <label for="vendedor_id" class="form-label">Vendedor</label>
                    <input type="text" class="form-control" value="{{ $ticket->vendedor->nome }}" readonly>
                </div>


                <button type="submit" class="btn btn-primary">Atualizar Ticket</button>
            </form>
        </div>
    </div>
</x-app-layout>
