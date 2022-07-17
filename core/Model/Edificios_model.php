<?php

include_once './utils/DBException.php';
include_once './Model/Base_Model.php';

class Edificios_model extends Base_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function addEdificio($universidad, $nombre, $ubicacion)
    {

        $sql = "INSERT INTO edificio ( id_UNIVERSIDAD , nombre, ubicacion, borrado) VALUES ( ? , ? , ? , 0 )";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iss", $universidad, $nombre, $ubicacion);
        $stmt->execute();

        $resultado = $stmt->insert_id;

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();


        return $resultado;
    }

    function editEdificio($id, $universidad, $nombre, $ubicacion)
    {
        $sql = "UPDATE edificio SET id_UNIVERSIDAD=?, nombre=?, ubicacion=? WHERE id=?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("issi", $universidad, $nombre, $ubicacion, $id);
        $stmt->execute();

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();


        return true;
    }

    function mostrartodos()
    {
        $sql = "SELECT edificio.id, edificio.id_UNIVERSIDAD AS universidad, universidad.nombre AS universidad_nombre, edificio.nombre, edificio.ubicacion FROM edificio, universidad WHERE edificio.id_UNIVERSIDAD = universidad.id";

        $resultado = $this->db->query($sql);

        return array("edificios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function deleteEdificio($id): bool
    {

        $sql = "DELETE FROM edificio WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);


        $resultado = $stmt->execute();


        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar ese edificio");
        }

        $stmt->close();

        return $resultado;
    }

    public function show($id)
    {
        $sql = "SELECT  edificio.id AS id,
                        edificio.id_UNIVERSIDAD AS universidad, 
                        universidad.nombre AS universidad_nombre, 
                        edificio.nombre AS nombre, 
                        edificio.ubicacion AS ubicacion 
                FROM edificio, universidad 
                WHERE edificio.id_UNIVERSIDAD = universidad.id AND edificio.id=?";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar ese edificio");
        }

        $stmt->close();

        return array("edificios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    public function getEdificios()
    {
        $sql = "SELECT  edificio.id AS id,
                        universidad.nombre AS universidad_nombre, 
                        edificio.nombre AS nombre, 
                        edificio.ubicacion AS ubicacion 
                FROM edificio, universidad 
                WHERE edificio.id_UNIVERSIDAD = universidad.id";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }


}