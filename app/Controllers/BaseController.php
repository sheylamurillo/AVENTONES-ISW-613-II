<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */

    protected $helpers = ['options_helper'];


    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = session(); //Inicializamos la session en Todos los controladores

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }
    protected function render(string $view, array $data = [])
    {
        $session = session();

        if (!$session->has('user')) {
            $header = 'layouts/headerSearchPublic';
        } else {
            $role = $session->get('user')['role'];

            switch ($role) {
                case 'Driver':
                    $header = 'layouts/headerDriver';
                    break;
                case 'Passenger':
                    $header = 'layouts/headerPassenger';
                    break;
                case 'Admin':
                    $header = 'layouts/headerAdmin';
                    break;
                default:
                    $header = 'layouts/headerSearchPublic';
            }
    }

    
    return view($header, $data)
         . view($view, $data)
         . view('layouts/footer');
}

}
