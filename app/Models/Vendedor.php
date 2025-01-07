<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Vendedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nome', 'email', 'telefone', 'status', 'tickets_abertos', 'tickets_em_andamento', 'tickets_resolvidos'
    ];

    protected $table = 'vendedores';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'vendedor_id'); 
    }

    public function ticketsAbertos()
    {
        return $this->hasMany(Ticket::class, 'vendedor_id')->where('status', 'Aberto');
    }

    public function ticketsEmAndamento()
    {
        return $this->hasMany(Ticket::class, 'vendedor_id')->where('status', 'Em andamento');
    }

    public function ticketsResolvidos()
    {
        return $this->hasMany(Ticket::class, 'vendedor_id')->where('status', 'Resolvido');
    }
}
