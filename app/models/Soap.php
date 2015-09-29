<?php
class Soap
{
    
    public static function server(){
        $url=Request::url();

        $namespace = $url."?wsdl";
        $server = new nusoap_server;
        $server->configureWSDL('PartidaAbiertas', $url, $url );
        //$server->configureWSDL("psi", "urn:psi");
        //$server->wsdl->schemaTargetNamespace = $namespace;
        $server->soap_defencoding = 'UTF-8';
        $server->register(
            'registroUsuario',
            array('usuario'=> 'xsd:string'),
            array('return' => 'xsd:string'),
            $namespace,
            $url,
            'rpc',
            'encoded',
            'ws Dedica ala agregacion de usuarios'
        );
        function registroUsuario($usuario){
            $datos='aaaa';
            return json_encode($datos);
        }
        //$rawPostData = file_get_contents("php://input");
        //var_dump( $rawPostData);
        //echo Response::make($server->service($rawPostData), 200, array('Content-Type' => 'text/xml', 'charset' => 'UTF-8'));
        return Response::make(@$server->service($HTTP_RAW_POST_DATA), 200, array('Content-Type' => 'text/xml', 'charset' => 'UTF-8'));
    }
    /*public function registroUsuario($usuario){
        $datos='aaaa';
        return json_encode($datos);
    }*/
}