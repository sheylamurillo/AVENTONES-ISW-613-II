<?php

namespace App\Models;

use CodeIgniter\Model;


class VehiclesModel extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'idVehicle';

    protected $allowedFields = [ 
        'idUser', 'plateNumber', 'color', 'brand', 'model',
        'year', 'seatCapacity', 'picture', 'status'
    ];

    public function getVehiclesByUser($idUser)
    {
        return $this->select('idVehicle, plateNumber, color, brand, model, year, seatCapacity, picture')
                    ->where('idUser', $idUser)
                    ->where('status', 'Active')
                    ->findAll();
    }

   public function getIdVehByPlate($plate)
   {
        return $this->select('idVehicle')
                    ->where('plateNumber', $plate)
                    ->where('status', 'Active')
                    ->first()['idVehicle'] ?? null;
    }

}
