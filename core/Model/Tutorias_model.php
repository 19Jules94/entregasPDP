<?php

include_once './utils/ResourceNotFound.php';

class Tutorias_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodas()
    {
        $sql = "SELECT tutoria.id AS id, tutoria.fecha AS fecha, tutoria.hora_inicio AS hora_inicio, tutoria.hora_fin as hora_fin,
                anhoacademico.anho AS anho, usuario.dni AS profesor, usuario.nombre AS nombre, usuario.apellidos AS apellidos, espacio.nombre AS espacio,
                tutoria.asistencia AS asistencia
                FROM tutoria, anhoacademico, espacio, usuario
                WHERE tutoria.id_ANHOACADEMICO = anhoacademico.id AND tutoria.id_PROFESOR = usuario.dni AND tutoria.id_ESPACIO = espacio.id";

        $resultado = $this->db->query($sql);

        return array("tutorias" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addTutoria($id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin){
        $sql = "INSERT INTO tutoria (id_ANHOACADEMICO, id_PROFESOR, id_ESPACIO, asistencia, fecha, hora_inicio, hora_fin, borrado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $date = date('Y-m-d',strtotime($fecha));
        $stmt->bind_param("isissss", $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin);

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

    function editTutoria($id, $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin){
        $sql = "UPDATE tutoria SET id_ANHOACADEMICO=?, id_PROFESOR=?, id_ESPACIO=?, asistencia=?, fecha=?, hora_inicio=?, hora_fin=?, borrado=0
                WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $date = date('Y-m-d',strtotime($fecha));

        $stmt->bind_param("isissssi", $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin, $id);

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
            throw new ResourceNotFound("No se ha podido encontrar la tutoria");
        }

        $stmt->close();
        return $resultado;
    }

    function deleteTutoria($id){
        $sql = "DELETE FROM tutoria WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if($stmt->affected_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar la tutoria");
        }

        $stmt->close();

        return $resultado;
    }

    function asistencia($id,$asistencia){

        $sql = "UPDATE tutoria SET asistencia=? WHERE id=? ";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("si", $asistencia, $id);

        $resultado = $stmt->execute();

        if ($stmt->affected_rows == 0) {
            throw new ResourceNotFound("No se ha podido encontrar la tutoria");
        }
        $stmt->close();
        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT tutoria.id AS id, tutoria.fecha AS fecha, tutoria.hora_inicio AS hora_inicio, tutoria.hora_fin as hora_fin, tutoria.asistencia AS asistencia,
                anhoacademico.anho AS anho, usuario.dni AS profesor, usuario.nombre AS nombre, usuario.apellidos AS apellidos, espacio.nombre AS espacio,
                espacio.id AS espacio_id, anhoacademico.id AS anhoacademico_id
                FROM tutoria, anhoacademico, usuario, espacio
                WHERE tutoria.id_ANHOACADEMICO = anhoacademico.id AND tutoria.id_PROFESOR = usuario.dni AND tutoria.id_ESPACIO = espacio.id AND tutoria.id = '".$id."'";
        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar esa tutoria");
        }

        return array("tutorias" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getTutorias($profesor)
    {
        $sql = "SELECT tutoria.id AS id, tutoria.fecha AS fecha, tutoria.hora_inicio AS hora_inicio, tutoria.hora_fin as hora_fin,
                anhoacademico.anho AS anho, usuario.dni AS profesor, usuario.nombre AS nombre, usuario.apellidos AS apellidos, espacio.nombre AS espacio,
                tutoria.asistencia AS asistencia
                FROM tutoria, anhoacademico, espacio, usuario
                WHERE tutoria.id_ANHOACADEMICO = anhoacademico.id AND tutoria.id_PROFESOR = usuario.dni AND tutoria.id_ESPACIO = espacio.id AND tutoria.id_PROFESOR = '".$profesor."'";

        $resultado = $this->db->query($sql);

        return array("tutorias" => $resultado->fetch_all(MYSQLI_ASSOC));
    }
}