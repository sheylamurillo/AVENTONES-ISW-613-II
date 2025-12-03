<?php

namespace App\Controllers;

use App\Traits\AuthTrait;

class Driver extends BaseController
{
    use AuthTrait;

    public function bookings()
    {
    
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verifications; // Redirección si no está logueado o no es driver
        }

        return view('users/driver/bookings');
    }
}

