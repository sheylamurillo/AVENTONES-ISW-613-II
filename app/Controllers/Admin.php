<?php
namespace App\Controllers;
use App\Models\UsersModel;


class Admin extends BaseController
{
    public function loadAllUsers()
    {
        $session = session();

        //Verificar si hay sesión iniciada
        if (!$session->has('user')) {
            return redirect()->to('/')->with('error', 'noSession');
        }

        //Verificar rol de usuario
        if ($session->get('user')['role'] !== 'Admin') {
            return redirect()->to('/')->with('error', 'permission');
        }

        // Si todo bien, cargar vista
        $model = new UsersModel();
        $data['users'] = $model->select('idUser, ID, name, lastName, role, status')->findAll();

        return view('users/administrator/showAllUsers', $data);
    }
}

