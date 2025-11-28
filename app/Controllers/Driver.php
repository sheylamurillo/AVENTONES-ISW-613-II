<?php
namespace App\Controllers;

class Driver extends BaseController
{
    public function bookings()
    {
        $session = session();

        //Verificar si hay sesión iniciada
        if (!$session->has('user')) {
            return redirect()->to('/')->with('error', 'noSession');
        }
        return view('users/driver/bookings');
    }
}
