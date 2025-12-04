<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use App\Models\RidesModel;
use App\Libraries\Email;

class Script extends BaseCommand
{
    protected $group = 'Custom'; // Clasificar el comando en un grupo
    protected $name = 'script:pendingBookings'; //Nombre del comando para ejecutarlo
    protected $description = 'Envía correos de bookings pendientes que superen X minutos';//Explicación el propósito

    

    public function run(array $params)
    {
        // Validar el parametro que sea vlido
        if (count($params) < 1) {
            echo "Uso: php spark script:pendingBookings <minutos>\n";
            return;
        }

        $minutes = (int)$params[0];

        if ($minutes <= 0) {
            echo "El parámetro <minutos> debe ser mayor a 0.\n";
            return;
        }

      
        $ridesModel = new RidesModel();
        $email = new Email();

        // Obtener los bookings pendientes desde el modelo 
        $rows = $ridesModel->getPendingBookings($minutes);

        if (empty($rows)) {
            echo "No hay reservas.\n";
            return;
        }

        /*Se declara un array que contendrá a los conductores que vienen de la cosnulta sql,
        en este array se almacenará/agruparán todas las reservas que tiene pendienten un chofer
        */
        $drivers = [];

        foreach ($rows as $row) {

            $driverEmail = $row['driver_email'];
            $driverName  = $row['driver_name'] . ' ' . $row['driver_lastName'];

            if (!isset($drivers[$driverEmail])) {
                $drivers[$driverEmail] = [
                    "name"     => $driverName,
                    "gmail"    => $driverEmail,
                    "bookings" => []
                ];
            }

            $drivers[$driverEmail]['bookings'][] = $row;
        }

        /*Objetivo: Recorrer drivers y crear tarjetas de los bookings pendientes con elementos HTML y enviar el correo al conductor.
        Extra: Si el array de drivers tiene elementos, se recorre, se obtienen los datos, luego se hace otro recorrido, en este caso los bookings
        agrupados, para obtener la información de booking está pendiente y enviarla al conductor.*/ 
        foreach ($drivers as $driver) {

            $driverName  = $driver['name'];
            $driverEmail = $driver['gmail'];
            $bookings    = $driver['bookings'];

            $subject = "Pending reservations.";
            $body  = "Hello, $driverName, you have pending reservations.<br><br>";

            foreach ($bookings as $b) {
                $clientName = $b['client_name'] . ' ' . $b['client_lastName'];

                $body .= "
                    <div style='border:1px solid #ccc; border-radius:8px; padding:10px; margin-bottom:10px;'>
                        <p><strong>Client:</strong> {$clientName}</p>
                        <p><strong>Origin:</strong> {$b['origin']}</p>
                        <p><strong>Destination:</strong> {$b['destination']}</p>
                        <p><strong>Date:</strong> {$b['rideDate']}</p>
                        <p><strong>Hour:</strong> {$b['departureTime']}</p>
                        <p><strong>Booking created:</strong> {$b['booking_time']}</p>
                    </div>
                ";
            }

          
            $email->send($driverEmail, $driverName, $subject, $body);

            echo "Email enviado a: $driverEmail\n";
        }
    }
}