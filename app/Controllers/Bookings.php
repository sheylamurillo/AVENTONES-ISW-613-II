<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Database;
use App\Models\bookingsModel;

class Bookings extends Controller
{
    public function index()
    {
        /*if (!session()->get('idUser') || !session()->get('role')) {
            return redirect()->to('/login');
        }*/

        if (!session()->has('user')) {
            return redirect()->to('/login');
        
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
        return view('bookings', $data);
    }

    public function create($idRide)
    {
        $bookingModel = new bookingsModel();
        $idUser = session()->get('user')['idUser'];
        $bookingModel->insertBooking($idRide, $idUser);
        return redirect()->to('/bookings');
    }

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
