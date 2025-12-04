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
            return $Verification; // Redirección si no está logueado o no es driver
        }

        $data['active'] = 'bookings';
        return $this->render('users/driver/bookings', $data);
    }
}

