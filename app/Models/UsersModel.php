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
}
