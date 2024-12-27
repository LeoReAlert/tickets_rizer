<h3>{{ $vendedor->nome }}</h3>
<p>Status: {{ $vendedor->status }}</p>

<h4>Tickets Abertos</h4>
<ul>
    @foreach ($ticketsAbertos as $ticket)
        <li>{{ $ticket->id }} - {{ $ticket->descricao }}</li>
    @endforeach
</ul>

<h4>Tickets Em Andamento</h4>
<ul>
    @foreach ($ticketsEmAndamento as $ticket)
        <li>{{ $ticket->id }} - {{ $ticket->descricao }}</li>
    @endforeach
</ul>

<h4>Tickets Resolvidos</h4>
<ul>
    @foreach ($ticketsResolvidos as $ticket)
        <li>{{ $ticket->id }} - {{ $ticket->descricao }}</li>
    @endforeach
</ul>
