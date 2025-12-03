<?php
namespace App\Controllers;
use App\Traits\AuthTrait;

class Passenger extends BaseController
{
    use AuthTrait;

    public function searchRides()
    {
        $session = session();

        $Verification = $this->verifyPassenger();
        if ($Verification !== null) {
            return $Verifications;
        }

        return view('users/passenger/searchRides');
    }
}
