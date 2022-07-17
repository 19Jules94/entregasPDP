<?php

include_once './utils/ResourceNotFound.php';

class Centros_model extends Base_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodos()
    {
        $sql = "SELECT centro.id AS id, centro.nombre AS nombre, centro.ciudad AS ciudad, centro.responsable AS responsable, universidad.nombre 
        AS universidad_nombre, universidad.ciudad AS universidad_ciudad, universidad.responsable AS universidad_responsable FROM centro, universidad 
        WHERE centro.id_UNIVERSIDAD = universidad.id";

        $resultado = $this->db->query($sql);

        return array("centros" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addCentro($nombre, $universidad, $ciudad, $responsable){
        $sql = "INSERT INTO centro (nombre, id_UNIVERSIDAD, ciudad, responsable, borrado) VALUES (?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("siss", $nombre,$universidad, $ciudad, $responsable);

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

    function editCentro($id, $nombre,$universidad, $ciudad, $responsable){
        $sql = "UPDATE centro SET nombre=?, id_UNIVERSIDAD=?, ciudad=?, responsable=?, borrado=0 WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sissi", $nombre, $universidad, $ciudad, $responsable, $id);

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
            throw new ResourceNotFound("No se ha podido encontrar el centro");
        }

        $stmt->close(); 
        return $resultado;
    }

    function deleteCentro($id){
        $sql = "DELETE FROM centro WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        
        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if($stmt->affected_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar el centro");
        }

        $stmt->close();

        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT centro.id AS id, centro.nombre AS nombre, centro.ciudad AS ciudad, centro.responsable AS responsable, universidad.nombre AS universidad_nombre, universidad.id AS universidad_id, universidad.responsable AS universidad_responsable FROM centro, universidad WHERE centro.id_UNIVERSIDAD = universidad.id AND centro.id = '".$id."'";
        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar ese centro");
        }

        return array("centros" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getCentros()
    {
        $sql = "SELECT id, nombre, ciudad, responsable, id_UNIVERSIDAD AS universidad_id FROM centro";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}