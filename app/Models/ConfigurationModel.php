<?php

namespace App\Models;
use CodeIgniter\Model;

class ConfigurationModel extends Model
{
    protected $table      = 'configuration';
    protected $primaryKey = 'idConfiguration';

    protected $allowedFields = ['idUser', 'publicname', 'publicbio'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /*Se encarga de insertar la configuración del usuario en la base de datos, inserta el public name, bio y id de usuario */
    public function insertConfiguration($idUser,$publicName,$publicBio){
        return $this->insert([
            'idUser' => $idUser,
            'publicname' => $publicName,
            'publicbio' => $publicBio
        ]);
    }

    /*Se encarga de actualizar la configuración del usuario en la base de datos; actualiza el public name y bio  */
    public function updateConfiguration($idUser, $publicName, $publicBio)
    {
        return $this->where('idUser', $idUser)->set([
            'publicname' => $publicName,
            'publicbio'  => $publicBio
        ])->update();
    }

    /*Obtiene la configuración de un usuario de la BD para enviarla al controlador*/
    public function getConfigurationData($idUser)
    {
        return $this->select('publicname, publicbio')
                    ->where('idUser', $idUser)
                    ->get()
                    ->getRowArray(); 
    }

}