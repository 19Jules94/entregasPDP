<?php

include_once './utils/ResourceNotFound.php';

class Grupos_model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodos()
    {
        $sql = "SELECT grupo.id AS id, grupo.codigo AS codigo, grupo.nombre AS nombre, grupo.tipo as tipo, grupo.horas as horas, anhoacademico.anho AS anho,
        asignatura.nombre AS asignatura, titulacion.nombre AS titulacion FROM grupo, anhoacademico, asignatura, titulacion 
        WHERE grupo.id_ANHOACADEMICO = anhoacademico.id AND grupo.id_ASIGNATURA = asignatura.id and grupo.id_TITULACION = titulacion.id";

        $resultado = $this->db->query($sql);

        return array("grupos" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addGrupo($id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas){
        $sql = "INSERT INTO grupo (id_ANHOACADEMICO, id_ASIGNATURA, id_TITULACION, codigo, nombre, tipo, horas, borrado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("iiisssi", $id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas);

        $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->errno==1452) {
            $stmt->close();
            throw new DBException("4004");
        }


        $resultado = $stmt->insert_id;

        $stmt->close();

        return $resultado;
    }

    function editGrupo($id, $id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas){
        $sql = "UPDATE grupo SET id_ANHOACADEMICO=?, id_ASIGNATURA=?, id_TITULACION=?, codigo=?, nombre=?, tipo=?, horas=?, borrado=0 WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("iiisssii", $id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas,$id);

        $resultado = $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->errno==1452) {
            $stmt->close();
            throw new DBException("4004");
        }

        if($stmt->affected_rows == 0){
            throw new ResourceNotFound("No se han realizado cambios.");
        }

        $stmt->close();
        return $resultado;
    }

    function deleteGrupo($id){
        $sql = "DELETE FROM grupo WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if($stmt->affected_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar el grupo");
        }

        $stmt->close();

        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT grupo.id AS id, 
        grupo.codigo AS codigo, 
        grupo.nombre AS nombre, 
        grupo.tipo as tipo, 
        grupo.horas as horas, 
        anhoacademico.anho AS anho,
        asignatura.id AS asignatura, 
        asignatura.nombre AS asignatura_nombre, 
        titulacion.id AS titulacion,
        titulacion.nombre AS titulacion_nombre

        FROM grupo, anhoacademico, asignatura, titulacion 

        WHERE grupo.id_ANHOACADEMICO = anhoacademico.id AND grupo.id_ASIGNATURA = asignatura.id and grupo.id_TITULACION = titulacion.id and grupo.id = '".$id."'";
        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar ese departamento");
        }

        return array("grupos" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getGrupos()
    {
        $sql = "SELECT grupo.id AS id, grupo.codigo AS codigo, grupo.nombre AS nombre, grupo.tipo as tipo, grupo.horas as horas, anhoacademico.anho AS anho,
        asignatura.nombre AS asignatura, titulacion.nombre AS titulacion FROM grupo, anhoacademico, asignatura, titulacion 
        WHERE grupo.id_ANHOACADEMICO = anhoacademico.id AND grupo.id_ASIGNATURA = asignatura.id and grupo.id_TITULACION = titulacion.id";

        $resultado = $this->db->query($sql);

        return array("grupos" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getGrupos2()
    {
        $sql = "SELECT grupo.id AS id, grupo.codigo AS codigo, grupo.nombre AS nombre, grupo.tipo as tipo, grupo.horas as horas, anhoacademico.anho AS anho,
        asignatura.nombre AS asignatura_nombre,
        asignatura.id AS asignatura,
        titulacion.nombre AS titulacion_nombre,
        titulacion.id AS titulacion
        FROM grupo, anhoacademico, asignatura, titulacion 
        WHERE grupo.id_ANHOACADEMICO = anhoacademico.id AND grupo.id_ASIGNATURA = asignatura.id and grupo.id_TITULACION = titulacion.id";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}