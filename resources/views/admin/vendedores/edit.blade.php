<x-app-layout>
    <x-slot name="header">
        <h1>Editar Vendedor</h1>
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

    @if (session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
            <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="container mt-5">
        <form action="{{ route('vendedores.update', $vendedor->id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Usuário</label>
                <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="user_id"
                    name="user_id" value="{{ old('user_id', $vendedor->user_id) }}" required readonly>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome"
                    name="nome" value="{{ old('nome', $vendedor->nome) }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email', $vendedor->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone"
                    name="telefone" value="{{ old('telefone', $vendedor->telefone) }}" required>
                @error('telefone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Selecione o status</option>
                    <option value="Ativo" {{ old('status', $vendedor->status) == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="Inativo" {{ old('status', $vendedor->status) == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Vendedor</button>
        </form>
    </div>
</x-app-layout>
