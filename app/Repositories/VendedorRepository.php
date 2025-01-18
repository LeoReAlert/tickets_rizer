<?php

namespace VendedorRespository;

use App\Models\Vendedor;

class VendedorRespository{
  public function GetAllVendedor(){
    $vendedor = Vendedor::all();
  }
  public function GetUniqueVendedor($user_id){
    $vendedor = Vendedor::findOrFail($user_id);
  }
}
