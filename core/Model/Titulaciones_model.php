<?php

include_once './utils/ResourceNotFound.php';

class Titulaciones_model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodas()
    {
        $sql = "SELECT titulacion.id AS id, 
        titulacion.codigo AS codigo, 
        titulacion.nombre AS nombre, 
        CONCAT(usuario.nombre,' ',usuario.apellidos) AS responsable,  
        usuario.dni AS responsable_dni, 
        centro.id as centro_id, 
        centro.nombre AS centro,
        centro.ciudad AS centro_ciudad,
        anhoacademico.anho AS anho_id  
         FROM titulacion, usuario, centro, anhoacademico WHERE titulacion.responsable = usuario.dni AND titulacion.id_CENTRO = centro.id
        AND titulacion.id_ANHOACADEMICO = anhoacademico.id";

        $resultado = $this->db->query($sql);

        return array("titulaciones" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addTitulacion($id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable){
        $sql = "INSERT INTO titulacion (id_ANHOACADEMICO, id_CENTRO, codigo, nombre, responsable, borrado) VALUES (?, ?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("iisss", $id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable);

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

    function editTitulacion($id, $id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable){
        $sql = "UPDATE titulacion SET id_ANHOACADEMICO=?, id_CENTRO=?, codigo=?, nombre=?, responsable=?,borrado=0 WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("iisssi", $id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable, $id);

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
            throw new ResourceNotFound("No se ha podido encontrar el centro, responsable o año académico.");
        }

        $stmt->close();
        return $resultado;
    }

    function deleteTitulacion($id){
        $sql = "DELETE FROM titulacion WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if($stmt->affected_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar la titulación.");
        }

        $stmt->close();

        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT titulacion.id AS id, 
        titulacion.codigo AS codigo, 
        titulacion.nombre AS nombre, 
        CONCAT(usuario.nombre,' ',usuario.apellidos) AS responsable,  
        usuario.dni AS responsable_dni, 
        centro.id as centro_id, 
        centro.nombre AS centro,
        centro.ciudad AS centro_ciudad,
        anhoacademico.id AS anho_id,
        anhoacademico.anho AS anho
        
        FROM titulacion, usuario, centro, anhoacademico WHERE titulacion.responsable = usuario.dni AND titulacion.id_CENTRO = centro.id
         AND titulacion.id_ANHOACADEMICO = anhoacademico.id and titulacion.id = '".$id."'";
        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar esa titulación");
        }

        return array("titulaciones" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getTitulaciones()
    {
        $sql = "SELECT titulacion.id AS id, 
        titulacion.codigo AS codigo, 
        titulacion.nombre AS nombre, 
        CONCAT(usuario.nombre,' ',usuario.apellidos) AS responsable, 
        usuario.dni AS responsable_dni, 
        centro.id as centro_id, 
        centro.nombre AS centro,
        centro.ciudad AS centro_ciudad,
        anhoacademico.id AS anho_id,
        anhoacademico.anho AS anho

        FROM titulacion, usuario, centro, anhoacademico WHERE titulacion.responsable = usuario.dni AND titulacion.id_CENTRO = centro.id
         AND titulacion.id_ANHOACADEMICO = anhoacademico.id";
        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);

    }
}