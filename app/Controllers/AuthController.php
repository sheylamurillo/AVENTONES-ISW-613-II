<?php

namespace App\Controllers;

use App\Models\UsersModel;

class AuthController extends BaseController
{
    public function login(){
        return view('auth/login');
    }

    public function registerPassenger(){
        return view ('users/passenger/registerPassenger');

    }

    public function registerDriver(){
        return view ('users/driver/registerDriver');

    }


    public function authenticate(){
    $session = session();
    $model = new UsersModel();

    $gmail = $this->request->getPost('gmail');
    $password = $this->request->getPost('password');

    $user = $model->where('gmail', $gmail)->first();

    if (!$user) {
        // Usuario no encontrado
        $session->setFlashdata('error', 'notfound'); //FlashData es una session que al leerse, se destruye
        return redirect()->back()->withInput(); //Signifa que se redirecciona al url anterior, o sea de donde viene
    }

    if (!password_verify($password, $user['password'])) {
        // Contraseña incorrecta
        $session->setFlashdata('error', 'passwords');
        return redirect()->back()->withInput(); //WithInput hace que puedas conservar lo escrito en los campos
    }

    // Validaciones de estado
    if ($user['status'] === 'pending') {
        $session->setFlashdata('error', 'pending');
        return redirect()->back()->withInput();
    }

    if ($user['status'] === 'inactive') {
        $session->setFlashdata('error', 'inactive');
        return redirect()->back()->withInput();
    }

    // Si todo esta bien, entonces
    $session->set('user', $user);

    switch ($user['role']) {
        case 'Driver':
            return redirect()->to('/driver/bookings');
        case 'Passenger':
            return redirect()->to('/passenger/searchRides');
        case 'Admin':
            return redirect()->to('/allUsers');
        default:
            //Por si acaso
            return redirect()->to('/');
    }
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
