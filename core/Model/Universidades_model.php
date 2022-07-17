<?php

include_once './Utils/ResourceNotFound.php';

class Universidades_model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodas()
    {
        $sql = "SELECT universidad.id AS id, universidad.nombre AS nombre, universidad.ciudad AS ciudad, universidad.responsable AS responsable, usuario.nombre AS responsable_nombre, usuario.apellidos AS responsable_apellidos FROM universidad, usuario WHERE universidad.responsable = usuario.dni";

        $resultado = $this->db->query($sql);

        return array("universidades" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addUniversidad($nombre, $ciudad, $responsable){
        $sql = "INSERT INTO universidad (nombre, ciudad, responsable, borrado) VALUES (?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sss", $nombre, $ciudad, $responsable);

        $stmt->execute();

        $resultado=$stmt->insert_id;

        if ($stmt->errno==1452) {
            $stmt->close();
            throw new DBException("4004");
        }

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $resultado;
    }

    function editUniversidad($id, $nombre, $ciudad, $responsable){
        $sql = "UPDATE universidad SET nombre=?, ciudad=?, responsable=?, borrado=0 WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sssi", $nombre, $ciudad, $responsable, $id);

        $resultado=$stmt->execute();

        if($stmt->affected_rows==0){
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar la universidad");
        }

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $resultado;
    }

    function deleteUniversidad($id){
        $sql = "DELETE FROM universidad WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        if($stmt->affected_rows==0){
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar la universidad");
        }

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT universidad.id AS id, universidad.nombre AS nombre, universidad.ciudad AS ciudad, universidad.responsable AS responsable, usuario.nombre AS responsable_nombre, usuario.apellidos AS responsable_apellidos FROM universidad, usuario WHERE universidad.responsable = usuario.dni AND universidad.id = '".$id."'";
        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar esa universidad");
        }

        return array("universidades" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getUniversidades()
    {
        $sql = "SELECT universidad.id AS id, universidad.nombre AS nombre, universidad.ciudad AS ciudad, universidad.responsable AS responsable, usuario.nombre AS responsable_nombre, usuario.apellidos AS responsable_apellidos FROM universidad, usuario WHERE universidad.responsable = usuario.dni";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}