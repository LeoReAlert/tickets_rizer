<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendedor;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'status', 'vendedor_id', 'suporte_id'];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function suporte()
    {
    return $this->belongsTo(User::class, 'suporte_id');
    }

    public function statusLabel()
    {
        $statusLabels = [
            'ABERTO' => 'Aberto',
            'EM ANDAMENTO' => 'Em andamento',
            'RESOLVIDO' => 'Resolvido',
        ];

        return $statusLabels[strtoupper($this->status)] ?? 'Desconhecido';
    }

}
