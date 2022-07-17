<?php

include_once './Model/Profesores_model.php';
include_once './Model/Usuarios_model.php';
include_once './Model/Departamentos_model.php';
include_once './utils/ValidationException.php';
include_once './utils/ResourceNotFound.php';
include_once './utils/Validaciones.php';
class Profesores_Service
{    
    
    private $USUARIOS_M;
    private $DEPARTAMENTOS_M;
    private $PROFESORES_M;

    function __construct()
    {
        $this->DEPARTAMENTOS_M = new Departamentos_model();
        $this->USUARIOS_M = new Usuarios_model();
        $this->PROFESORES_M = new Profesores_model();
    }


    public function addProfesor($dni, $departamento, $dedicacion)
    {

        if (validarDNI($dni)!=true){
            throw new ValidationException("El DNI introducido no es válido");
        }

        if (validarNombreDep($dedicacion)!=true){
            throw new ValidationException("La dedicación introducida no es válida.");
        }

        if (validarId($departamento)!=true){
            throw new ValidationException("El ID del departamento no es válido.");
        }

        return $this->PROFESORES_M->addProfesor($dni, $departamento, $dedicacion);
    }

    function info_add()
    {
        $usuarios = $this->USUARIOS_M->getUsuarios();
        $departamentos = $this->DEPARTAMENTOS_M->getDepartamentos();
        return array("usuarios" => $usuarios, "departamentos" => $departamentos);
    }

    function mostrarTodos()
    {
        return $this->PROFESORES_M->mostrarTodos();
    }

    function deleteProfesor($dni)
    {
        if (validarDNI($dni)!=true){
            throw new ValidationException("El dni proporcionado no es válido");
        }
        return $this->PROFESORES_M->deleteProfesor($dni);
    }

    function editProfesor($dni, $departamento, $dedicacion)
    {

        if (validarDNI($dni)!=true){
            throw new ValidationException("El DNI introducido no es válido");
        }

        if (validarNombreDep($dedicacion)!=true){
            throw new ValidationException("La dedicación introducida no es válida.");
        }

        if (validarID($departamento)!=true){
            throw new ValidationException("El ID del departamento no es válido.");
        }

        return $this->PROFESORES_M->editProfesor($dni, $departamento, $dedicacion);
    }

    function show($dni)
    {
        if (validarDNI($dni)!=true){
            throw new ValidationException("El DNI proporcionado no es válido");
        }
        return $this->PROFESORES_M->show($dni);
    }



}