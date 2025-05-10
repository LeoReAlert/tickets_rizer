<?php

namespace App\Repositories;

use App\Models\Vendedor;
use Illuminate\Support\Facades\Log;

class VendedorRepository{
  public function GetAllVendedor(){
    $vendedor = Vendedor::all();

    return $vendedor;
  }
  public function GetUniqueVendedor($user_id){

    $vendedor = Vendedor::find($user_id);

    return $vendedor;
  }
}
