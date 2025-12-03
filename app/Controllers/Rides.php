<?php
namespace App\Controllers;

use App\Models\VehiclesModel;
use App\Models\RidesModel;
use App\Models\UsersModel;
use App\Models\ReportModel;
use App\Traits\AuthTrait;


class Rides extends BaseController
{
    use AuthTrait;


    public function loadAllRidesfromUserLogged(){
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }
        

        $idUser = $this->session->get('user')['idUser'];

        $ridesModel = new RidesModel();
        $data['rides'] = $ridesModel->loadRidesByUser($idUser);

        return view('rides/myRides', $data);


    }

    public function newRide(){
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }
        
        $idUser = $this->session->get('user')['idUser'];


        $modelVehicles = new VehiclesModel();
        $data['vehicles'] = $modelVehicles->getVehiclesByUser($idUser);
        return view('rides/newRide', $data);

    }

    public function storeRide(){
       $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }

        $data = $this->request->getPost();
         return $this->saveRide($data);
    }




	private function saveRide($data)
    {
    
        $plate = $data['plate'];

        //Obtenemos el idVehicle según la placa
        $VehicleModel = new VehiclesModel();
        $idVehicle = $VehicleModel->getIdVehByPlate($plate);


        //Capturé los datos asi, ya que me estaba dando problema
        $rideData = [
            'idUser'         => $this->session->get('user')['idUser'],
            'origin'         => $data['departure-from'],
            'destination'    => $data['arrive-to'],
            'departureTime'  => $data['time'],
            'rideDate'       => implode(',', $data['days']), 
            'costPerSeat'    => $data['fee'],
            'availableSeats' => $data['seats'],
            'idVehicle'      => $idVehicle,
            'status'         => 'Active'
        ];

        //Se guarda el ride
        $RideModel = new RidesModel();
        $RideModel->save($rideData);

        return redirect()->to('/rides');
    }


    public function editRide($idRide)
    {
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }

        $rideModel = new RidesModel();
        $vehicleModel = new VehiclesModel();

        $ride = $rideModel->find($idRide);
       
        $idUser = $this->session->get('user')['idUser'];
        $vehicles = $vehicleModel->getVehiclesByUser($idUser);

        $data = [
            'ride'     => $ride,
            'vehicles' => $vehicles,
            'days'     => ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
            'selectedDays' => explode(',', $ride['rideDate'])
        ];

        return view('rides/editRide', $data);
    }

    public function updateRide($idRide)
    {
        //Validacion
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }

        $rideModel = new RidesModel();
        $vehicleModel = new VehiclesModel();

        $data = $this->request->getPost();

        $plate = $data['plate'];
        $idVehicle = $vehicleModel->getIdVehByPlate($plate); //Buscamos el id con la placa

       //armamos el arreglo con los datos
        $rideData = [
            'origin'         => $data['origin'],
            'destination'    => $data['destination'],
            'departureTime'  => $data['departureTime'],
            'rideDate'       => implode(',', $data['days']),
            'costPerSeat'    => $data['costPerSeat'],
            'availableSeats' => $data['availableSeats'],
            'idVehicle'      => $idVehicle,
            'status'         => 'Active' 
        ];

        
        $rideModel->update($idRide, $rideData);

        return redirect()->to('/rides');
    }



     public function rideDetails($idRide)
    {
       
        $rideModel     = new RidesModel();
        $vehicleModel  = new VehiclesModel();
        $userModel     = new UsersModel();

        $ride = $rideModel->find($idRide);


        // Obtener vehículo del ride
        $vehicle = $vehicleModel->find($ride['idVehicle']);

        // Obtener driver del ride
        $driver = $userModel->select('name, lastName, picture')
                            ->where('idUser', $ride['idUser'])
                            ->first();

        $data = [
            'ride'         => $ride,
            'vehicle'      => $vehicle,
            'driver'       => $driver,
            'rideDays'     => explode(',', $ride['rideDate']),
            'days'         => ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
            'role'         => $this->session->get('user')['role']
        ];

        return view('rides/rideDetails', $data);
    }

    public function inactivate($idRide)
    {
        $Verification = $this->verifyDriver();
        if ($Verification !== null) {
            return $Verification;
        }
        $rideModel = new RidesModel();

        $rideModel->update($idRide, ['status' => 'Inactive']);
        
        return redirect()->to('/rides');
    }





    //-----------------------------------SEARCH REPORT---------------------------

    //se encarga de cargar los datos del reporte de acuerdo a un rango de fechas que viene por el formulario
    public function loadSearchReportByDate()
    {
        $reportModel = new ReportModel();
        $data = ['search' => [], 'dateFrom' => '',
            'dateTo' => ''];
         if ($this->request->getMethod() === 'POST') {
            $date1 = $this->request->getPost('dateFrom');
            $date2 = $this->request->getPost('dateTo');

           
            $data = [
            'search' => $reportModel->getSearchResultByDate($date1, $date2),
            'dateFrom' => $date1,
            'dateTo' => $date2
            ];
         }
        return view('users/administrator/searchReport', $data);
    }

    //se encarga de guardar las búsquedas realizadas por el usuario, en caso de que el usuario sea 0 se guarda cuál fue el id de la búsqueda generada para
    //actualizar después esa búsqueda que originalmente guardó el usuario en 0 porque viene de search publico
    private function saveSearch($idUser, $origin, $destination, $resultsCount)
    {
        $reportModel = new ReportModel();

        $autoIdBD = $reportModel->insertSearch([
            'idUser'        => $idUser,
            'origin'        => $origin,
            'destination'   => $destination,
            'results_count' => $resultsCount
        ]);

      
        if ($idUser == 0) {
            session()->set('last_public_search_id', $autoIdBD);
        }
    }

    //actualiza el id del usuario quien realizó primero la búsqueda en el search publico
    private function updatePublicSearch($idUser)
    {
        $session = session();
        $reportModel = new ReportModel();

        $lastId = $session->get('last_public_search_id');

        if ($lastId) {
            $reportModel->updateSearchUser($lastId, $idUser);
            $session->remove('last_public_search_id'); 
        }
    }
  
   

    //-----------------------------------SEARCH RIDES----------------------------

    // Obtiene los orígenes y destinos desde el modelo y los prepara para ser usados en los select de la vista.
    public function loadSelectOptions (){
        $ridesModel = new RidesModel();
        return [
            'origins'=> $ridesModel->getOrigin(),
            'destinations' => $ridesModel->getDestination()
        ];
    }

    //Alterna el orden actual entre ASC y DESC para los botones de ordenamiento.
    private function resolveOrder($currentOrder)
    {
        return ($currentOrder === 'ASC') ? 'DESC' : 'ASC';
    }


    //Lee los filtros desde el formulario, calcula el orden a aplicar y obtiene los viajes filtrados del modelo.
    private function processFilters()
    {
        $rideModel = new RidesModel();

        //obteemos las vriables que provienen del formulario de Search Rides
        $origin = $this->request->getPost('from') ?? '';
        $destination = $this->request->getPost('to') ?? '';
        $days = $this->request->getPost('days') ?? [];

      //obtenemos las variables que nos permiten ordenar la información
        $order = $this->request->getPost('order') ?? 'ASC';
        $orderBy = $this->request->getPost('orderBy') ?? 'departureTime';

       
        //vericamos si se hizo click en los botones de asc/desc y qué columna fue
        if ($this->request->getPost('change_order')) {
            $orderBy = $this->request->getPost('change_order');
            $order = $this->resolveOrder($order);
        }
        
        $rides = $rideModel->filter($origin, $destination, $days, $orderBy, $order);
        return [
            'rides'               => $rides,
            'originSelected'      => $origin,
            'destinationSelected' => $destination,
            'days'                => $days,
            'order'               => $order,
            'orderBy'             => $orderBy
        ];
    }

    // Carga los datos necesarios para la vista Search Rides.Si no hay POST, inicializa los valores por defecto. Finalmente envía todo a la vista.
    public function loadData(bool $isPublic){
        $session = session();
        $data = $this->loadSelectOptions();
        if ($this->request->getMethod() === 'POST') {

            $data = array_merge($data, $this->processFilters());

            $origin        = $data['originSelected'] ?: 'No seleccionado';
            $destination   = $data['destinationSelected'] ?: 'No seleccionado';
            $resultsCount  = count($data['rides']);

            if ($isPublic) {
               
               $this->saveSearch(null, $origin, $destination, $resultsCount);
            } 
            else {
               
                $idUser = $session->get('user')['idUser'];
                $this->saveSearch($idUser, $origin, $destination, $resultsCount);
            }
        }
        else {
            $data['rides']               = [];
            $data['originSelected']      = '';
            $data['destinationSelected'] = '';
            $data['days']                = [];
            $data['order']               = 'ASC';
            $data['orderBy']             = 'departureTime';
        }
        $data['isPublic'] = $isPublic;
        return view('searchRides/searchRides', $data);
    }

    //Sirve para que el user no tenga que repetir la búsqueda de cuando hizo el filtro en search public, cuando inicia sesión se mantendrá la búsqueda realiza en el search publico
    private function loadDataFromSavedFilters($filters)
    {
        $session = session();
        $rideModel = new RidesModel();

        $idUser = $session->get('user')['idUser'];

      
        $this->updatePublicSearch($idUser);

        $rides = $rideModel->filter(
            $filters['from'],
            $filters['to'],
            $filters['days'] ?? [],
            $filters['orderBy'] ?? 'departureTime',
            $filters['order'] ?? 'ASC'
        );


        $data = $this->loadSelectOptions();
        $data['rides']               = $rides;
        $data['originSelected']      = $filters['from'];
        $data['destinationSelected'] = $filters['to'];
        $data['days']                = $filters['days'] ?? [];
        $data['order']               = $filters['order'] ?? 'ASC';
        $data['orderBy']             = $filters['orderBy'] ?? 'departureTime';
        $data['isPublic']            = false;

        return view('searchRides/searchRides', $data);
    }


    /* Carga la búsqueda privada de Rides. Si existen filtros guardados desde la búsqueda pública,se cargan esos resultados . Si no,
    simplemente se muestra la vista privada vacía o con datos por defecto*/
    public function searchRidesPrivate(){
        $session = session();
        if ($session->has('filters_public')) {
            $filters = $session->get('filters_public');

            $session->remove('filters_public');
            return $this->loadDataFromSavedFilters($filters);
        }
        return $this->loadData(false);
    }


    //Carga la búsqueda pública de Rides. Si el usuario envía el formulario, se guardan las opciones seleccioandas en sesión para poder restaurarlos después del login.
    public function searchRidesPublic(){
        $session = session();

        if ($this->request->getMethod() === 'POST') {

        $session->set('filters_public', [
            'from'      => $this->request->getPost('from'),
            'to'        => $this->request->getPost('to'),
            'days'      => $this->request->getPost('days'),
            'order'     => $this->request->getPost('order'),
            'orderBy'   => $this->request->getPost('orderBy'),
        ]);
    }
        return $this->loadData(true);
    }

}


