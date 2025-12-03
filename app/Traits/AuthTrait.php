<?php

namespace App\Traits;

trait AuthTrait
{
    protected function verifyLogged()
    {
        $session = session();

        if (!$session->has('user')) {
            return redirect()->to('/')->with('error', 'noSession');
        }
        return null;
    }

    protected function verifyDriver()
    {
        $Verification = $this->verifyLogged();
        if ($Verification !== null) {
            return $Verifications;
        }
        

        if (session()->get('user')['role'] !== 'Driver') {
            return redirect()->to('/')->with('error', 'permission');
        }
        return null;
    }

    protected function verifyPassenger()
    {
        $Verification = $this->verifyLogged();
        if ($Verification !== null) {
            return $Verifications;
        }

        if (session()->get('user')['role'] !== 'Passenger') {
            return redirect()->to('/')->with('error', 'permission');
        }
        return null;
    }

    protected function verifyAdmin()
    {
        $Verification = $this->verifyLogged();
        if ($Verification !== null) {
            return $Verifications;
        }

        if (session()->get('user')['role'] !== 'Admin') {
            return redirect()->to('/')->with('error', 'permission');
        }
        return null;
    }
}
