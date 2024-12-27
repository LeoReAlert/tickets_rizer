<h3>Ticket: {{ $ticket->titulo }}</h3>
<p><strong>Descrição:</strong> {{ $ticket->descricao }}</p>
<p><strong>Status:</strong> {{ $ticket->statusLabel() }}</p>
<p><strong>Vendedor:</strong> {{ $ticket->vendedor->nome }}</p>
<p><strong>Data de Criação:</strong> {{ $ticket->created_at }}</p>
<p><strong>Data de Atualização:</strong> {{ $ticket->updated_at }}</p>
