<?php

namespace App\Models;
use CodeIgniter\Model;

class usersModel extends Model
{
    protected $table      = 'configuration';
    protected $primaryKey = 'idConfiguration';

    protected $allowedFields = ['idUser', 'publicname', 'publicbio'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';



    public function insertConfiguration($idUser,$publicName,$publicBio){
        return $this->insert([
            'idUser' => $idUser,
            'publicname' => $publicName,
            'publicbio' => $publicBio
        ]);
    }

    public function updateConfiguration($idUser, $publicName, $publicBio)
    {
        return $this->where('idUser', $idUser)->set([
            'publicname' => $publicName,
            'publicbio'  => $publicBio
        ])->update();
    }

    public function getConfigurationData($idUser)
    {
        return $this->select('publicname, publicbio')
                    ->where('idUser', $idUser)
                    ->get()
                    ->getRowArray(); 
    }





























    public function insertBooking($idRide, $idUser) {
        return $this->insert([
            'idRide' => $idRide,
            'idUser' => $idUser,
            'status' => 'pending'
        ]);
    }

   
    public function loadBookings($idUser, $role)
    {
        $builder = $this->select('b.idBooking, u.name, u.lastName, r.origin, r.destination, b.status')
                        ->from('bookings b')
                        ->join('users u','b.idUser = u.idUser')    
                        ->join('rides r','b.idRide = r.idRide');

        if ($role === 'Driver') {
            $builder->where('r.idUser', $idUser);   // El driver es dueño del ride
        } else {
            $builder->where('b.idUser', $idUser);   // El cliente es dueño del booking
        }

        return $builder->groupBy('b.idBooking')->findAll();
    }



    public function updateStatus($idBooking,$status){
        return $this->update($idBooking, ['status' => $status]);
    }

    
   public function getBookingsByRide($idRide) {
        return $this->where('idRide', $idRide)
                    ->where('status', 'accepted')
                    ->countAllResults() > 0;
    }
   
}