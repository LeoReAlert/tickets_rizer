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
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
