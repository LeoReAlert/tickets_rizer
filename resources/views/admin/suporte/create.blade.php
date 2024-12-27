<h1>Cadastrar Suporte</h1>

<form method="POST" action="{{ route('suporte.store') }}">
    @csrf

    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmar Senha</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>
