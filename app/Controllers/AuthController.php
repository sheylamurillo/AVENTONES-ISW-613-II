<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\TokensModel;
use App\Libraries\Email;

class AuthController extends BaseController
{
    public function login(){
        $session = session();
        
        // si no viene del login de search publico eliminar los datos de busqueda
        if ($this->request->getGet('req') != 1) {
            $session->remove('filters_public');
        }
        $data['active'] = ''; 
        return view('auth/login', $data);
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

        //validamos qué acción ejecutó el usuario,si, login corriente o passwordless
        $action = $this->request->getPost('action');
        if ($action === 'passwordless') {
            return $this->processPasswordless();
        }

        $gmail = $this->request->getPost('gmail');
        $password = $this->request->getPost('password');

        $user = $model->where('gmail', $gmail)->first();

    

        if (!$user) {
            // Usuario no encontrado
            $session->setFlashdata('error', 'notfound'); //FlashData es una session que al leerse, se destruye
            return redirect()->back()->withInput(); //Signifa que se redirecciona hacia donde provino la petición
        }

        if (!password_verify($password, $user['password'])) {
            // Contraseña incorrecta
            $session->setFlashdata('error', 'password');
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

        return $this->redirectByRole($user['role']);
    }


    //direcciona a los usuarios de acuerdo a su rol
    private function redirectByRole($role)
    {
        switch ($role) {
            case 'Driver':
                return redirect()->to('/vehicles');

            case 'Passenger':
                return redirect()->to('searchRides/searchRides');

            case 'Admin':
                return redirect()->to('/allUsers');

            default:
            //Por si acaso
                return redirect()->to('/');
        }
    }

    //Verifica si el correo digitado existe,luego, genera un token de acceso único y envía al usuario un enlace para iniciar sesión sin contraseña. 
    private function processPasswordless()
    {
        $session = session();   
        $email = $this->request->getPost('gmail');

        $usersModel = new UsersModel();
        $tokensModel = new TokensModel();

       
        $user = $usersModel->where('gmail', $email)->first();

        if (!$user) {
            $session->setFlashdata('error', 'notfound');
            return redirect()->back();
        }
        $token = bin2hex(random_bytes(16));

        $tokensModel->saveToken($user['idUser'], $token);

        $this->sendLinkPasswrodLess($email, $user['name'], $token);
       
        $session->setFlashdata('success', 'linkSent');
        return redirect()->back();
    }   


    //se encarga de envíar el correo
     private function sendLinkPasswrodLess($email, $firstName,$token)
     {
        $emailService = new Email();

        $link = base_url("passwordless/login/{$token}");

        $subject = "Hello $firstName! Your passwordless login link";

        $body = " Link:  <a href='{$link}'>{$link}</a>";
        $emailService->send($email, $firstName, $subject, $body);
    }


    // Valida el token de acceso, crea una sesion e inicia sesión al usuario si es válido y redirige según su rol. 
    public function passwordlessLogin($token)
    {
        $tokensModel = new TokensModel();
        $usersModel = new UsersModel();

        
        $tokenData = $tokensModel->getToken($token);

        if (!$tokenData) {
            $message = "Invalid token.";
            return view('statusPages/usedLink', ['message' => $message]);
        }

        if ($tokenData['status'] !== 'unused') {
            $message = "This login link has already been used.";
            return view('statusPages/usedLink', ['message' => $message]);
        }
        
        $user = $usersModel->find($tokenData['idUser']);

        $tokensModel->updateTokenStatus($token, 'used');
    
        session()->set('user', $user);

        return $this->redirectByRole($user['role']);
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
