<?php

require_once 'autoload.php';

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
ini_set("default_charset", "UTF-8");


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json; charset=UTF-8');

if (!isset($_REQUEST['controller'])) {

    http_response_code(400);
} else {
    switch ($_REQUEST['controller']) { //se evalua la action que llega por get
        case 'login':
            new Login_controller();
            break;
        case 'usuarios':
            new Usuarios_controller();
            break;
        case 'acciones':
            new Acciones_controller();
            break;
        case 'funcionalidades':
            new Funcionalidades_controller();
            break;
        case 'roles':
            new Roles_controller();
            break;
        case 'permisos':
            new Permisos_controller();
            break;
        case 'aacademico':
            new AAcademico_controller();
            break;
        case 'profesores':
            new Profesores_controller();
            break;
        case 'edificios':
            new Edificios_controller();
            break;
        case 'universidades':
            new Universidades_controller();
            break;
        case 'centros':
            new Centros_controller();
            break;
        case 'departamentos':
            new Departamentos_controller();
            break;
        case 'rol_usuario':
            new Rol_Usuario_controller();
            break;
        case 'titulaciones':
            new Titulaciones_controller();
            break;
        case 'asignaturas':
            new Asignaturas_controller();
            break;
        case 'espacios':
            new Espacios_controller();
            break;
        case 'grupos':
            new Grupos_controller();
            break;
        case 'horarios':
            new Horarios_controller();
            break;
        case 'tutorias':
            new Tutorias_controller();
        case 'pod':
            new POD_Controller();
            break;
        case 'pda':
            new PDA_Controller();
            break;
            

        default:
            http_response_code(400);
    }
}
