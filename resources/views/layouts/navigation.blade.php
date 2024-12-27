<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>
        <button class="btn btn-light" onclick="window.location.href='{{ route('dashboard') }}'" type="button">
            Painel
        </button>
        @role('support')
            <!-- Dropdown Vendedores -->
            <div class="dropdown ms-4">
                <button class="btn btn-light dropdown-toggle" type="button" id="vendedoresDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Vendedores
                </button>
                <ul class="dropdown-menu" aria-labelledby="vendedoresDropdown">
                    <li><a class="dropdown-item" href="#">Cadastrar Vendedor</a></li>
                    <li><a class="dropdown-item" href="#">Listar Vendedores</a></li>
                </ul>
            </div>
        @endrole
        @hasrole('vendedor|support')
            <!-- Dropdown Tickets -->
            <div class="dropdown ms-4">
                <button class="btn btn-light dropdown-toggle" type="button" id="ticketsDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Tickets
                </button>
                <ul class="dropdown-menu" aria-labelledby="ticketsDropdown">
                    <!-- Rota para o formulário de criação de ticket -->
                    <li><a class="dropdown-item" href="{{ route('tickets.create') }}">Cadastrar Ticket</a></li>

                    <!-- Rota para listar os tickets -->
                    <li><a class="dropdown-item" href="{{ route('tickets.index') }}">Listar Tickets</a></li>
                </ul>
            </div>
        @endhasrole

        <!-- Mobile Hamburger Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Settings Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
