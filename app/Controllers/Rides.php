<?php
namespace App\Controllers;

use App\Models\RidesModel;


class Rides extends BaseController
{

    public function index()
    {

    }
    
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
    public function loadData(){
        $data = $this->loadSelectOptions();
        if ($this->request->getMethod() === 'POST') {
            $data = array_merge($data, $this->processFilters());
        } 
        else {
            $data['rides']               = [];
            $data['originSelected']      = '';
            $data['destinationSelected'] = '';
            $data['days']                = [];
            $data['order']               = 'ASC';
            $data['orderBy']             = 'departureTime';
        }
        return view('searchRides/searchRides', $data);
    }

}


