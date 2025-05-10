<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository{
    public function getAllUsers()
    {
        return User::all();
    }
    public function GetUniqueUser($id){
        return User::find($id);
    }

}
