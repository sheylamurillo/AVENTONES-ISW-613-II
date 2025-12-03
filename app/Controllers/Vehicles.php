<?php
namespace App\Controllers;
use App\Models\VehiclesModel;
use App\Traits\AuthTrait;

class Vehicles extends BaseController
{
   
    use AuthTrait;


    public function storeVehicle(){
       $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
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
    $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }
        

    $vehicleModel = new VehiclesModel();
    $vehicle = $vehicleModel->find($id);

    $data['vehicle'] = $vehicle;
    return view('users/driver/editVehicles', $data);
    }


    public function updateVehicle($id)
    {
       $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }
        

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
       $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }
        

        $vehicleModel = new VehiclesModel();

        // Actualizamos solo estado
        $vehicleModel->update($id, ['status' => 'Inactive']);

        return redirect()->to('/vehicles');
    }






    public function loadAllVehiclesfromUserLogged(){
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }
        

        $idUser = $this->session->get('user')['idUser'];

        $vehicleModel = new VehiclesModel();
        $data['vehicles'] = $vehicleModel->getVehiclesByUser($idUser);

        return view('users/driver/myVehicles', $data);


    }

    public function newVehicle(){
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }

        return view('users/driver/newVehicle');
    }

        



}