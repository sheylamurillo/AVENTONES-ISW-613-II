<?php
namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ConfigurationModel;
use App\Libraries\Email;

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
        
        public function storeAdmin()
    {
        $data = $this->request->getPost();
        $data['role'] = 'Admin';
        return $this->saveUser($data);
   
    }

    public function storePassenger()
    {
        $data = $this->request->getPost();
        $data['role'] = 'Passenger';
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
        unset($data['repeat-password']); //No guarde el campo de repeat pass

        if ($data['role'] == 'Admin') {
            $data['status'] = 'active';
        } else {
            $data['status'] = 'pending';
        }

        $model = new UsersModel();
        $result = $model->save($data);
       
        if ($result && $data['role'] != 'Admin') {
            $this->sendActivationEmail( $data['gmail'],$data['name'], $data['token'] );
        }
        
        return redirect()->to('login'); //pagina de espera a confirmacion de cuenta (Sheyla)
    }

    private function sendActivationEmail($email, $firstName, $token)
    {
        $emailService = new Email();

        $activationLink = base_url("activate/{$token}");

        $subject = "Hello $firstName! Activate your account now";

        $body = " Link:  <a href='{$activationLink}'>{$activationLink}</a>";
        $emailService->send($email, $firstName, $subject, $body);
    }


    /*Si el usuario está autenticado,obtiene los datos del formulario y revisa si el usuario ya tiene un registro de configuración: 
      si existe, lo actualiza; de lo contrario, lo guarda por primera vez. */

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

    //Si el usuario está autenticado, obtiene su configuración desde el modelo y la envía a la vista para mostrarla en el formulario.
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

    //Este método sirve para activar la cuenta de un usuario
    public function activate($token)
    {
        $model = new UsersModel();
        $result = $model->activateUser($token);
        return view('statusPages/activateAccount');
    }

    


}


