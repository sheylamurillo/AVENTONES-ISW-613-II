<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Database;
use App\Models\usersModel;

class Users extends Controller
{
    public function index()
    {
        
    }
    
   public function saveConfiguration()
    {
        $session = session();

      
        if (!session()->has('user')) {
            return redirect()->to('/login');
        }

        $idUser = $session->get('user')['idUser'];
        $publicName = $this->request->getPost('public-name');
        $publicBio  = $this->request->getPost('public-bio');

        $userModel = new usersModel();

        
        $existingConfig = $userModel->getConfigurationData($idUser);

        if ($existingConfig === null) {
            $userModel->insertConfiguration($idUser, $publicName, $publicBio);
        } else {
            $userModel->updateConfiguration($idUser, $publicName, $publicBio);
        }

        return redirect()->to('/configuration');
    }
    public function loadConfiguration(){
      
       
        $session = session();

        if (!session()->has('user')) {
            return redirect()->to('/login');
        }

        $idUser = $session->get('user')['idUser'];
        
        $usersModel = new usersModel();

        $configuration = $usersModel->getConfigurationData($idUser);
        $data['configuration'] = $configuration;
        return view('configuration', $data);
    }

    
}
