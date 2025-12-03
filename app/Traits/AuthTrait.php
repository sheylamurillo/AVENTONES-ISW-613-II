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
        if ($r = $this->verifyLogged()) return $r;

        if (session()->get('user')['role'] !== 'Driver') {
            return redirect()->to('/')->with('error', 'permission');
        }
        return null;
    }

    protected function verifyPassenger()
    {
        if ($r = $this->verifyLogged()) return $r;

        if (session()->get('user')['role'] !== 'Passenger') {
            return redirect()->to('/')->with('error', 'permission');
        }
        return null;
    }

    protected function verifyAdmin()
    {
        if ($r = $this->verifyLogged()) return $r;

        if (session()->get('user')['role'] !== 'Administrator') {
            return redirect()->to('/')->with('error', 'permission');
        }
        return null;
    }
}
