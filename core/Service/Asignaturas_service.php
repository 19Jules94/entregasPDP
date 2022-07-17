<?php

include_once './Model/Asignaturas_model.php';
include_once './Model/Profesores_model.php';
include_once './Model/Titulaciones_model.php';
include_once './Model/Departamentos_model.php'; 
include_once './utils/ValidationException.php';
include_once './utils/ResourceNotFound.php';
include_once './utils/Validaciones.php';
class Asignaturas_service
{
    private $ASIGNATURAS_M; 

    function __construct()
    {
        $this->ASIGNATURAS_M = new Asignaturas_model();
        $this->PROFESORES_M = new Profesores_Model();
        $this->TITULACIONES_M = new Titulaciones_Model();
        $this->DEPARTAMENTOS_M = new Departamentos_Model(); 
    }

    function addAsignatura($nombre, $codigo, $contenido, $creditos,$tipo,$horas,$cuatrimestre,
    $titulacion,$anhoacademico, $departamento,$profesor)
    {
        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarCodigoAsignatura($codigo)!=true){
            throw new ValidationException("El  código introducido no es valido.");
        }  

        
        if (validarHoras($horas)!=true){
            throw new ValidationException("Las horas proporcionadas no son válido");
        }

        if (validarTipo($tipo)!=true){
            throw new ValidationException("El  tipo introducido no es valido.");
        }  

        if (validarContenido($contenido)!=true){
            throw new ValidationException("El  contenido introducido no es valido.");
        }  

        if (validarCuatrimestre($cuatrimestre)!=true){
            throw new ValidationException("El  cuatrimestre introducido no es valido.");
        }  
       
        if (validarCreditos($creditos)!=true){
            throw new ValidationException("El valor de creditos introducido no es valido.");
        }

        if (validarDNI($profesor)!=true){
            throw new ValidationException("El id de responsable introducido no es válido.");
        }


        try {
            return $this->ASIGNATURAS_M->addAsignatura($nombre, $codigo, $contenido, $creditos,$tipo,$horas,$cuatrimestre,
            $titulacion,$anhoacademico, $departamento,$profesor);
        }catch (DBException $e){
            throw $e;
        }
    }

    function info_add()
    {
        $titulaciones = $this->TITULACIONES_M->getTitulaciones();
        $departamentos = $this->DEPARTAMENTOS_M->getDepartamentos();
        $usuarios= $this->PROFESORES_M->getProfesores();
        return array("titulaciones" => $titulaciones,"departamentos" => $departamentos,"profesores"=>$usuarios);
    }

    function mostrarTodas()
    {
        return $this->ASIGNATURAS_M->mostrarTodas();
    } 

    function show($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->ASIGNATURAS_M->show($id);
    }


    function editAsignatura($id, $nombre, $codigo, $contenido, $creditos,$tipo,$horas,$cuatrimestre,
    $titulacion,$anhoacademico, $departamento,$profesor)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarHoras($horas)!=true){
            throw new ValidationException("Las horas proporcionadas no son válido");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        
        if (validarContenido($contenido)!=true){
            throw new ValidationException("El  contenido introducido no es valido.");
        }  


        if (validarCuatrimestre($cuatrimestre)!=true){
            throw new ValidationException("El  cuatrimestre introducido no es valido.");
        }  
       
        
        if (validarTipo($tipo)!=true){
            throw new ValidationException("El  tipo introducido no es valido.");
        }  
        
        if (validarCreditos($creditos)!=true){
            throw new ValidationException("El valor de creditos introducido no es valido.");
        }

        if (validarCodigoAsignatura($codigo)!=true){
            throw new ValidationException("El  código introducido no es valido.");
        }  

        if (validarDNI($profesor)!=true){
            throw new ValidationException("El id de responsable introducido no es válido.");
        }
  
        try {
            return $this->ASIGNATURAS_M->editAsignatura($id, $nombre, $codigo, $contenido, $creditos,$tipo,$horas,$cuatrimestre,
            $titulacion,$anhoacademico, $departamento,$profesor);
        }catch (ResourceNotFound $e){
            throw $e;
        }catch (DBException $e){
            throw $e;
        }
    }


    function deleteAsignatura($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->ASIGNATURAS_M->deleteAsignatura($id);
    }


  
}