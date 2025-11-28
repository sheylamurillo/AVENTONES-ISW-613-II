<?php
namespace App\Controllers;

class Passenger extends BaseController
{
    public function searchRides()
    {
        $session = session();

        //Verificar si hay sesión iniciada
        if (!$session->has('user')) {
            return redirect()->to('/')->with('error', 'noSession');
        }
        return view('users/passenger/searchRides');
    }
}
