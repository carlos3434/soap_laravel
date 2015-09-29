<?php

class SoapController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */
    public function getServidor()
    {
        $server = new \soap_server;

        $server->configureWSDL('server.hello', 'urn:server.hello', Request::url());
        $server->wsdl->schemaTargetNamespace = 'urn:server.hello';

        $server->register('hello',
                array('name' => 'xsd:string'),
                array('return' => 'xsd:string'),
                'urn:server.hello',
                'urn:server.hello#hello',
                'rpc',
                'encoded',
                'Retorna o nome'
        );

        function hello($name)
        {
            return 'Hello ' . $name;
        }

        // respuesta para uso do serviço
        return Response::make($server->service(file_get_contents("php://input")), 200, array('Content-Type' => 'text/xml; charset=ISO-8859-1'));

    }
    public function getCliente()
    {
        // creacion de una instancia de cliente
        $client = new \nusoap_client('http://soap_laravel/servidor?wsdl', true);
        // verifica si existe un error en el objeto

        $result = $client->call('hello', array('Renato Araujo'));
        // resultado
        var_dump($result);

        echo '<h2>Request</h2>';
        echo '<pre>' . htmlspecialchars($client->request) . '</pre>';
        echo '<h2>Respuesta</h2>';
        echo '<pre>' . htmlspecialchars($client->response) . '</pre>';
        // mensage de debug
        echo '<h2>Debug</h2>';
        echo '<pre>' . htmlspecialchars($client->debug_str) . '</pre>';
    }
}
