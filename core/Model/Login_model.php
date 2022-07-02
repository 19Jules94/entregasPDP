<?php

include_once './Model/Base_model.php';
include_once './utils/AuthJWT.php';


class Login_model extends Base_Model{

    private $DNI;
    private $PASS;

    function __construct($DNI,$PASS)
    {
        parent::__construct();
        $this->DNI=$DNI;
        $this->PASS = $PASS;

        $this->erroresdatos = array();
    }

    function login(){
        $sql = "SELECT * FROM usuario WHERE dni='$this->DNI' AND password ='$this->PASS'";
        $result = $this->db->query($sql);

        if($result->num_rows == 0){
            return null;
        }else{
            return $result;
        }
    }

    function obtenerFuncionalidadesAcciones(){
        $sql = "SELECT funcionalidad.nombre AS 'FUNCIONALIDAD', accion.nombre AS 'ACCION' 
        FROM usuario_rol, rol_permiso, funcionalidad, accion  
        WHERE 
            usuario_rol.id_USUARIO = '$this->DNI' 
            AND usuario_rol.id_ROL = rol_permiso.id_ROL 
            AND rol_permiso.id_FUNCIONALIDAD = funcionalidad.id
            AND rol_permiso.id_ACCION = accion.id";
        $result = $this->db->query($sql)->fetch_all();

        $acciones = array();
        error_reporting(0);

        foreach ($result as $accion){
            $aux = $acciones[$accion[0]];
            if($aux != null){
                array_push($aux,$accion[1]);
                $acciones[$accion[0]] = $aux;
            }else{
                $acciones[$accion[0]]=array($accion[1]);
            }            
        }
        error_reporting(-1);
        return $acciones;
    }
    public function getProfile($dni)
    {
        $sql = "SELECT dni, nombre, apellidos, email FROM usuario WHERE dni='$dni'";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC)[0];
    }

}
