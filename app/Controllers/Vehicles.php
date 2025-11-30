<?php
namespace App\Controllers;
use App\Models\VehiclesModel;


class Vehicles extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session(); 
    }

    public function VerificationSessionAndRole(){
    

     //Verificar si hay sesión iniciada
        if (!$this->session->has('user')) {
            return redirect()->to('/')->with('error', 'noSession');
        }

        //Verificar rol de usuario
        if ($this->session->get('user')['role'] !== 'Driver') {
            return redirect()->to('/')->with('error', 'permission');
        }
    }


    public function storeVehicle(){
        $authResponse = $this->VerificationSessionAndRole();
        if ($authResponse) {
            return $authResponse; //Redirección si hay error
        }

        $data = $this->request->getPost();
        return $this->saveVehicle($data);
    }

	private function saveVehicle($data){
        $file = $this->request->getFile('picture');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/vehicles/', $fileName);
            $data['picture'] = 'uploads/vehicles/' . $fileName;
        }

        $data['idUser'] = $this->session->get('user')['idUser'];
        $data['status'] = "active";

        $model = new VehiclesModel();
        $model->save($data);

        return redirect()->to('/vehicles');

    }


    public function editVehicle($id){
    $authResponse = $this->VerificationSessionAndRole();
    if ($authResponse) return $authResponse;

    $vehicleModel = new VehiclesModel();
    $vehicle = $vehicleModel->find($id);

    $data['vehicle'] = $vehicle;
    return view('users/driver/editVehicles', $data);
    }


    public function updateVehicle($id)
    {
        $authResponse = $this->VerificationSessionAndRole();
        if ($authResponse) return $authResponse;

        $vehicleModel = new VehiclesModel();

        // Obtener los datos del formulario
        $data = $this->request->getPost();

        // Si se envió una imagen nueva
        $file = $this->request->getFile('picture');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/vehicles/', $fileName);
            $data['picture'] = 'uploads/vehicles/' . $fileName;
        }

        // Agregar el ID del usuario por seguridad
        $data['idUser'] = $this->session->get('user')['idUser'];

        $vehicleModel->update($id, $data);

        return redirect()->to('/vehicles');
    }

    public function inactivateVehicle($id){
    $authResponse = $this->VerificationSessionAndRole();
    if ($authResponse) return $authResponse;

    $vehicleModel = new VehiclesModel();

    // Actualizamos solo estado
    $vehicleModel->update($id, ['status' => 'Inactive']);

    return redirect()->to('/vehicles');
    }






    public function loadAllVehiclesfromUserLogged(){
        $authResponse = $this->VerificationSessionAndRole();
        if ($authResponse) {
            return $authResponse; //Redirección si hay error
        }

        $idUser = $this->session->get('user')['idUser'];

        
        $vehicleModel = new VehiclesModel();
        $data['vehicles'] = $vehicleModel->getVehiclesByUser($idUser);

        return view('users/driver/myVehicles', $data);


    }

    public function newVehicle(){

        return view('users/driver/newVehicle');
    }

        



}