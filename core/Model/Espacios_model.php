<?php

class Espacios_model extends Base_Model
{

    public function addEspacio($edificio, $nombre, $tipo)
    {
        $sql = "INSERT INTO espacio ( id_EDIFICIO, nombre, tipo, borrado) VALUES ( ? , ? , ? , 0 )";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iss", $edificio, $nombre, $tipo);
        $stmt->execute();

        $resultado = $stmt->insert_id;

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->errno == 1452) {
            $stmt->close();
            throw new DBException("4004");
        }

        $stmt->close();


        return $resultado;
    }

    public function mostrarTodos()
    {
        $sql = "SELECT espacio.id AS id, edificio.id AS edificio, edificio.nombre AS edificio_nombre, edificio.ubicacion AS edificio_ubicacion, universidad.nombre AS edificio_universidad, espacio.nombre, espacio.tipo
                FROM edificio, espacio, universidad
                WHERE edificio.id = espacio.id_EDIFICIO AND edificio.id_UNIVERSIDAD = universidad.id";

        $resultado = $this->db->query($sql);

        return array("espacios" => $resultado->fetch_all(MYSQLI_ASSOC));

    }

    public function show($id)
    {
        $sql = "SELECT espacio.id AS id, edificio.id AS edificio, edificio.nombre AS edificio_nombre, edificio.ubicacion AS edificio_ubicacion, universidad.nombre AS edificio_universidad, espacio.nombre, espacio.tipo
                FROM edificio, espacio, universidad
                WHERE edificio.id = espacio.id_EDIFICIO AND edificio.id_UNIVERSIDAD = universidad.id AND espacio.id=?";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar ese espacio");
        }

        $stmt->close();

        return array("espacios" => $resultado->fetch_all(MYSQLI_ASSOC));

    }

    public function deleteEspacio($id)
    {
        $sql = "DELETE FROM espacio WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);


        $resultado = $stmt->execute();


        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar ese espacio");
        }

        $stmt->close();

        return $resultado;

    }

    public function editEspacio($id, $edificio, $nombre, $tipo)
    {
        $sql = "UPDATE espacio SET id_EDIFICIO=?, nombre=?, tipo=? WHERE id=?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("issi", $edificio, $nombre, $tipo, $id);
        $stmt->execute();

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->errno == 1452) {
            $stmt->close();
            throw new DBException("4004");
        }

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar ese espacio");
        }

        $stmt->close();


        return true;
    }

    public function getEspacios()
    {
        $sql = "SELECT espacio.id AS id,
        edificio.id AS edificio,
        edificio.nombre AS edificio_nombre,
        edificio.ubicacion AS edificio_ubicacion,
        universidad.id AS edificio_universidad,
        espacio.nombre AS nombre,
        espacio.tipo AS tipo

                FROM edificio, espacio, universidad
                WHERE edificio.id = espacio.id_EDIFICIO AND edificio.id_UNIVERSIDAD = universidad.id";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);

    }
}
