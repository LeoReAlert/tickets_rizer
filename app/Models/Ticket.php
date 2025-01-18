<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendedor;
use App\Models\User;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['assunto', 'descricao', 'status', 'vendedor_id', 'suporte_id'];

    
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'vendedor_id');
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
            'ATRASADO' => 'Atrasado',
        ];

        return $statusLabels[strtoupper($this->status)] ?? 'Desconhecido';
    }
}
