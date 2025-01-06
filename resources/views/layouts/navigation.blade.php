<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">

        <div class="d-flex align-items-center">
         
            <a class="navbar-brand me-3" href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>

            <button class="btn btn-light me-3" onclick="window.location.href='{{ route('dashboard') }}'" type="button">
                Painel
            </button>

            @role('support')
                <div class="dropdown me-3">
                    <button class="btn btn-light dropdown-toggle" type="button" id="vendedoresDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Vendedores
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="vendedoresDropdown">
                        <li><a class="dropdown-item" href="{{ route('vendedores.create') }}">Cadastrar Vendedor</a></li>
                        <li><a class="dropdown-item" href="{{ route('vendedores.index') }}">Listar Vendedores</a></li>
                    </ul>
                </div>
            @endrole

                @hasrole('vendedor|support')
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="ticketsDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Tickets
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="ticketsDropdown">
                    
                        @role('support')
                            <li><a class="dropdown-item" href="{{ route('tickets.create') }}">Cadastrar Ticket</a></li>
                        @endrole
                
                        <li><a class="dropdown-item" href="{{ route('tickets.index') }}">Listar Tickets</a></li>
                    </ul>
                </div>
            @endhasrole

        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

       
         @if(Auth::check())
        <li class="nav-item dropdown" style="list-style:none;">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">{{ __('Sair') }}</button>
                    </form>
                </li>
            </ul>
        </li>
        @endif
    </div>
</nav>
