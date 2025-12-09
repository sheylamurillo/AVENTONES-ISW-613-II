<?php
namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ConfigurationModel;
use App\Libraries\Email;
use App\Traits\AuthTrait;

class Users extends BaseController
{

    use AuthTrait;

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

    public function desactivateUsers()
    {
        if ($Verification = $this->verifyAdmin()) {
            return $Verification;
        }

        $idUser = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $userModel = new UsersModel();
        $userModel->update($idUser, ['status' => $status]);

        return $this->response->setJSON(['success' => true]);
    }

    public function newAdmin(){
        if ($Verification = $this->verifyAdmin()) {
            return $Verification;
        }
        $data['active'] = 'users';
        return $this->render('users/administrator/newAdmin',$data);

    }

    public function saveAdmin()
    {
        if ($Verification = $this->verifyAdmin()) {
            return $Verification;
        }

        $data = $this->request->getPost();
        $userModel = new UsersModel();

        //Subida de imagen
        $file = $this->request->getFile('picture');
        $picturePath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/users/', $fileName);
            $picturePath = 'uploads/users/' . $fileName;
        }

        //Datos
        $Data = [
            'ID'          => $data['ID'],
            'name'        => $data['name'],
            'lastName'    => $data['lastName'],
            'gmail'       => $data['gmail'],
            'phoneNumber' => $data['phoneNumber'],
            'birthDate'   => $data['birthDate'],
            'address'     => $data['address'],
            'password'    => password_hash($data['password'], PASSWORD_DEFAULT),
            'picture'     => $picturePath,
            'role'        => 'Admin',     
            'status'      => 'active',    
            'token'       => 'ABC'         
        ];

        $userModel->insert($Data);

        return redirect()->to('/allUsers');
    }




    /*Si el usuario está autenticado,obtiene los datos del formulario y revisa si el usuario ya tiene un registro de configuración: 
      si existe, lo actualiza; de lo contrario, lo guarda por primera vez. */

    public function saveConfiguration() 
    {
        
        $Verification = $this->verifyLogged();
        if ($Verification !== null) {
            return $Verification;
        }

        $session = session();
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

    public function loadUserDetails(){
        $Verification = $this->verifyLogged();
        if ($Verification !== null) {
            return $Verification; // Redirección si no está logueado
        }
        $session = session();
        $idUser = $session->get('user')['idUser'];
        $role   = $session->get('user')['role'];
        $userModel = new UsersModel();

        $data['user'] = $userModel->find($idUser);
        $data['active'] = '';
        if ($role === 'Admin') {
            $data['cancelRoute'] = base_url('/allUsers');
        } 
        else if ($role === 'Driver') {
            $data['cancelRoute'] = base_url('/rides');
        } 
        else {
            $data['cancelRoute'] = base_url('/searchRides/searchRides');
        }
        return $this->render('users/editProfile', $data);  
        

    }

    public function saveProfileDetails(){

        $Verification = $this->verifyLogged();
        if ($Verification !== null) {
            return $Verification; // Redirección si no está logueado
        }

            
        $idUser = $this->session->get('user')['idUser'];

        //Obtener datos del formulario
        $data = $this->request->getPost();

        $userModel = new UsersModel();

        //Construir datos válidos para actualizar
        $updateData = [
            'name'        => $data['name'],
            'lastName'    => $data['lastName'],
            'ID'          => $data['ID'],
            'birthDate'   => $data['birthDate'],
            'gmail'       => $data['gmail'],
            'address'     => $data['address'],
            'phoneNumber' => $data['phoneNumber'],
        ];

        //Si el usuario ingresa una nueva contraseña
        if (!empty($data['password'])) {
            if ($data['password'] === $data['repeat-password']) {
                $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                return redirect()->back();
            }
        }

        //Manejar imagen
        $file = $this->request->getFile('picture');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filename = $file->getRandomName();
            $file->move('uploads/users/', $filename);
            $updateData['picture'] = 'uploads/users/' . $filename;
        }

        //Actualizar usuario
        $userModel->update($idUser, $updateData);
        return redirect()->to('/profile');
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
        $data['active'] = ''; // Ninguna opción activa
        return $this->render('configuration/configuration', $data); 
    } 

    //Este método sirve para activar la cuenta de un usuario
    public function activate($token)
    {
        $model = new UsersModel();
        $result = $model->activateUser($token);
        return view('statusPages/activateAccount');
    }

    


}


