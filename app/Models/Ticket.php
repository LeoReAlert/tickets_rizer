<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'status', 'vendedor_id'];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function statusLabel()
    {
        $statusLabels = [
            'Aberto' => 'Aberto',
            'Em andamento' => 'Em andamento',
            'Resolvido' => 'Resolvido',
        ];

        return $statusLabels[$this->status] ?? 'Desconhecido';
    }
}
