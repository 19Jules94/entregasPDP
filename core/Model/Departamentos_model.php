<?php

include_once './Utils/ResourceNotFound.php';

class Departamentos_model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodos()
    {
        $sql = "SELECT departamento.id AS id, departamento.codigo AS codigo, departamento.nombre AS nombre,  departamento.id_CENTRO AS id_centro, centro.nombre AS centro_nombre FROM departamento, centro 
        WHERE departamento.id_CENTRO = centro.id";

        $resultado = $this->db->query($sql);

        return array("departamentos" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addDepartamento($codigo, $centro, $nombre){
        $sql = "INSERT INTO departamento (id_CENTRO, codigo, nombre, borrado) VALUES (?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("iss", $centro, $codigo, $nombre);

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

    function editDepartamento($id, $codigo, $centro, $nombre){
        $sql = "UPDATE departamento SET id_CENTRO=?, codigo=?, nombre=?,borrado=0 WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("issi", $centro, $codigo, $nombre, $id);

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
            throw new ResourceNotFound("No se ha podido encontrar el departamento");
        }

        $stmt->close();
        return $resultado;
    }

    function deleteDepartamento($id){
        $sql = "DELETE FROM departamento WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if($stmt->affected_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar el departamento");
        }

        $stmt->close();

        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT departamento.id AS id, departamento.codigo AS codigo, departamento.nombre AS nombre,  departamento.id_CENTRO AS id_centro, centro.nombre AS centro_nombre FROM departamento, centro 
        WHERE departamento.id_CENTRO = centro.id and departamento.id = '".$id."'";
        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar ese departamento");
        }

        return array("departamentos" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getDepartamentos()
    {
        $sql = "SELECT departamento.id AS id, departamento.codigo AS codigo, departamento.nombre AS nombre,  departamento.id_CENTRO AS id_centro, centro.nombre AS centro_nombre FROM departamento, centro 
        WHERE departamento.id_CENTRO = centro.id";
        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

  
}