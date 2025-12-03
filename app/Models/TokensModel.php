<?php

namespace App\Models;

use CodeIgniter\Model;


class TokensModel extends Model
{
    protected $table = 'passwordlesstokens';
    protected $primaryKey = 'id';

    protected $allowedFields = [ 
        'idUser', 'token', 'status'];


    //esta función guarda los tokens generados en la base de datos
    public function saveToken($idUser, $token)
    {
        return $this->insert([
            'idUser'    => $idUser,
            'token'     => $token,
            'status'    => 'unused',
        ]);
    }

   //permite actualizar el estado del token, ya sea unused o used
    public function updateTokenStatus($token, $status)
    {
        return $this->where('token', $token)
                    ->set(['status' => $status])
                    ->update();
    }

    //busca si el token existe en la base de datos para ser utilizado
    public function getToken($token)
    {
        return $this->where('token', $token)->first();
    }
    
}
