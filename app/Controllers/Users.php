<?php
namespace App\Controllers;

use App\Models\UsersModel;


class Users extends BaseController
{

    public function index()
    {
        return view('users/passenger/registerPassenger');

    }

    public function storeDriver()
    {
        $data = $this->request->getPost();
        $data['role'] = 'Driver'; 
        return $this->saveUser($data); 
    }

    public function storePassenger()
    {
        $data = $this->request->getPost();
        $data['role'] = 'Passenger';
        return $this->saveUser($data);
    }

    public function storeAdmin()
    {
        $data = $this->request->getPost();
        $data['role'] = 'Admin';
        return $this->saveUser($data);
    }

    private function saveUser($data)
    {
        $file = $this->request->getFile('picture');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/users/', $fileName);
            $data['picture'] = 'uploads/users/' . $fileName;
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['token'] = bin2hex(random_bytes(16));
        $data['status'] = 'pending';
        unset($data['repeat-password']); //No guarde el campo de repeat pass

        $model = new UsersModel();
        $model->save($data);

        return redirect()->to('/'); //pagina de espera a confirmacion de cuenta (Sheyla)
    }

    public function saveConfiguration() 
    {
        $session = session(); 

        if (!session()->has('user')) 
        { 
            return redirect()->to('/login'); 
        } 

        $idUser = $session->get('user')['idUser']; 
        $publicName = $this->request->getPost('public-name'); 
        $publicBio = $this->request->getPost('public-bio'); 

        $configurationModel = new ConfigurationModel(); 

        $existingConfig = $configurationModel->getConfigurationData($idUser); 

        if ($existingConfig === null) { 
            $configurationModel->insertConfiguration($idUser, $publicName, $publicBio); 
        } 
        else {
            $configurationModel->updateConfiguration($idUser, $publicName, $publicBio); 
        }
        return redirect()->to('/configuration'); 
    }

    public function loadConfiguration()
    {
        $session = session(); 
        if (!session()->has('user')) 
        { 
            return redirect()->to('/login'); 
        } 
        $idUser = $session->get('user')['idUser']; 
        $configurationModel = new ConfigurationModel(); 
        $configuration = $configurationModel->getConfigurationData($idUser); 
        $data['configuration'] = $configuration; 
        return view('configuration/configuration', $data); 
    } 
}


