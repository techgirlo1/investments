<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function findUserById($userId);

    
}
