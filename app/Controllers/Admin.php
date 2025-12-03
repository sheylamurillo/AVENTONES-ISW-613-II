<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Traits\AuthTrait;

class Admin extends BaseController
{
    use AuthTrait;

    public function loadAllUsers()
    {
        $Verification = $this->verifyAdmin();
        if ($Verification !== null) {
            return $Verification; // Redirección si no está logueado o no es driver
        }

        

        $model = new UsersModel();
        $data['users'] = $model
            ->select('idUser, ID, name, lastName, role, status')
            ->findAll();

        return view('users/administrator/showAllUsers', $data);
    }
}

