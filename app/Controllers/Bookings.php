<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Database;
use App\Models\bookingsModel;
use App\Controllers\BaseController;

class Bookings extends BaseController
{

    /* Carga el listado de reservas del usuario autenticado que vienen desde el modelo.También determina, 
    según el rol y el estado de reserva, qué acciones (aceptar, rechazar o cancelar) están permitidas hacen en la vista.*/

    public function index()
    {
        $Verification = $this->verifyLogged();
        if ($Verification !== null) {
            return $Verification; // Redirección si no está logueado
        }

        $session = session();
        $idUser = $session->get('user')['idUser'];
        $role   = $session->get('user')['role'];

        $bookingModel = new BookingsModel();
        $bookings = $bookingModel->loadBookings($idUser,$role);
        
        foreach ($bookings as &$booking) {

            $status = $booking['status'];
            $booking['canAccept'] = ($role === 'Driver' && $status === 'pending');
            $booking['canReject'] = ($role === 'Driver' && $status === 'pending');
            $booking['canCancel'] = ($role === 'Passenger' && in_array($status, ['pending', 'accepted']));
        }

        $data['bookings'] = $bookings;
        $data['active'] = 'bookings';
        return $this->render('bookings/bookings', $data);
    }

    /*Este método recibe el ID de un ride, obtiene el ID del usuario actual y crea una reserva llamando al modelo.
      Finalmente redirige al listado de reservas.*/

    public function create($idRide)
    {
        $bookingModel = new bookingsModel();
        $idUser = session()->get('user')['idUser'];
        $bookingModel->insertBooking($idRide, $idUser);
        return redirect()->to('/bookings');
    }

    /*Actualiza el estado de una reservar de acuerdo a la acción recibida por parametro. 
      Cambia el estado en la base de datos  y luego redirige al listado de reservas*/

    public function updateStatus($idBooking, $action)
    {
        $bookingModel = new bookingsModel();
        if ($action === "accept") {
            $bookingModel->updateStatus($idBooking, "accepted");
        } elseif ($action === "reject") {
            $bookingModel->updateStatus($idBooking, "cancelled");
        }
         return redirect()->to('/bookings');
    }

    
}
