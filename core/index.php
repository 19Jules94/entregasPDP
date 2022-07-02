<?php

require_once 'autoload.php';

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
ini_set("default_charset", "UTF-8");
//error_reporting(0);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json; charset=UTF-8');

if (!isset($_REQUEST['controller'])) {
    
    http_response_code(400);
   
} else {
    switch ($_REQUEST['controller']) { //se evalua la action que llega por get
        case 'login': //Login
            new Login_controller();
            break;   
        case 'usuarios': //Login
            new Usuarios_controller();
            break;      
        case 'acciones': //Acciones
             new Acciones_controller();
             break;
        case 'funcionalidades': //Acciones
            new Funcionalidades_controller();
            break;
        default://caso default
            http_response_code(400);
    }
}