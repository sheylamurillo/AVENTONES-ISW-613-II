<?php

namespace App\Models;

use CodeIgniter\Model;


class RidesModel extends Model
{
    protected $table = 'rides';
    protected $primaryKey = 'idRide';

    protected $allowedFields = [ 
        'idUser', 'origin', 'destination', 'departureTime', 'rideDate',
        'costPerSeat', 'availableSeats', 'status',
        'idVehicle'
    ];

    public function loadRidesByUser($idUser)
    {
        return $this->select('*')
                    ->where('idUser', $idUser)
                    ->findAll();
    }

    /*Obtiene los datos de la columna de puntos de origen, luego serán cargadas en un select */
    public function getOrigin()
    {
        return $this->distinct()
                    ->select('origin')
                    ->findAll();
    }

    /*Obtiene los datos de la columna de puntos de destino, luego serán cargadas en un select */
    public function getDestination()
    {
        return $this->distinct()
                    ->select('destination')
                    ->findAll();
    }


    /*Propósito:Filtrar viajes de la base de datos según origen, destino, días y orden deseado, devolviendo solo aquellos viajes activos y con asientos disponibles.
	...Es un filtro con una consulta sql dinámica, que dependiendo que parámetros vengan con datos se le va añadiendo a la consulta, 
	en caso de que origen,destino y días vengas vacíos se devolverá un array vacío
	*/
    public function filter($origin = "", $destination = "", $days = [], $orderBy = "departureTime", $order = "ASC")
    {
        if (empty($origin) && empty($destination) && empty($days)) {
            return [];
        }

        $dynamicQuery = $this
                        ->select(" u.name,u.lastName,rides.origin,rides.destination,rides.availableSeats,rides.departureTime,rides.costPerSeat,rides.idRide,c.brand, c.model, c.year")
                        ->join('users u', 'rides.idUser = u.idUser')
                        ->join('vehicles c', 'rides.idVehicle = c.idVehicle')
                        ->where('rides.status', 'active')
                        ->where('rides.availableSeats >', 0);

    
        if (!empty($origin)) {
            $dynamicQuery->where('rides.origin', $origin);
        }

        if (!empty($destination)) {
            $dynamicQuery->where('rides.destination', $destination);
        }

        if (!empty($days)) {
            $dynamicQuery->groupStart();
            foreach ($days as $day) {
                $dynamicQuery->orLike('rides.rideDate', $day);
            }
            $dynamicQuery->groupEnd();
        }

    
        switch ($orderBy) {
            case 'from':
                $dynamicQuery->orderBy('rides.origin', $order);
                break;

            case 'to':
                $dynamicQuery->orderBy('rides.destination', $order);
                break;

            default:
                $dynamicQuery->orderBy('rides.departureTime', $order);
                break;
        }
            return $dynamicQuery->get()->getResultArray();
        }

    /*Carga los datos necesarios para la pantalla de ride details*/
    public function loadRideDetails($idRide)
    {
        return $this->select("
                    r.origin, r.destination, r.rideDate, r.departureTime,
                    r.availableSeats, r.costPerSeat, v.plateNumber,
                    v.brand, r.idRide, u.picture, u.name
                ")
                ->from('rides r')
                ->join('users u', 'r.idUser = u.idUser')
                ->join('vehicles v', 'r.idVehicle = v.idVehicle')
                ->where('r.idRide', $idRide)
                ->get()
                ->getResultArray();
    }

    //obtiene los bookings que se encuentran pendientes despues de x mintuos , este método es utilizado en el script
    public function getPendingBookings($minutes){
        return $this->select("
                        uD.name AS driver_name,
                        uD.lastName AS driver_lastName, 
                        uD.gmail AS driver_email,
                        rides.origin, 
                        rides.destination, 
                        rides.rideDate, 
                        rides.departureTime,
                        b.dateTime AS booking_time,
                        uC.name AS client_name, 
                        uC.lastName AS client_lastName
                    ")
                    ->join('bookings b', 'rides.idRide = b.idRide')
                    ->join('users uD', 'rides.idUser = uD.idUser')
                    ->join('users uC', 'b.idUser = uC.idUser')
                    ->where('b.status', 'pending')
                    ->where("TIMESTAMPDIFF(MINUTE, b.dateTime, NOW()) >", $minutes)
                    ->get()
                    ->getResultArray();

    }
    
}
