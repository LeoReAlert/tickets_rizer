<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository{
    public function getAllUsers()
    {
        return User::all();
    }
    public function GetUniqueUser($id){
        return User::find($id);
    }

}
