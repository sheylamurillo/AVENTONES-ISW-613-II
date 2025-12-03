<?php

namespace App\Models;

use CodeIgniter\Model;


class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'idUser';

    protected $allowedFields = [ 
        'ID', 'name', 'lastName', 'gmail', 'phoneNumber',
        'password', 'role', 'token', 'status',
        'birthDate', 'address', 'picture'
    ];

    public function updateStatus($idUser, $status)
    {
        return $this->where('idUser', $idUser)
                ->set(['status' => $status])
                ->update();
    }

    public function activateUser($token)
    {
        return $this->where('token', $token)
                ->set(['status' => 'active', 'token' => null])
                ->update();
    }

}
