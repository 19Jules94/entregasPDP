<?php
class Acciones_model extends Base_model
{

    function __construct()
    {
        parent::__construct();
    }

    function addAccion($nombre, $descr)
    {
        $sql = "INSERT INTO accion ( nombre,descripcion,borrado) VALUES(?,?,0)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ss', $nombre, $descr);
        $stmt->execute();
        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $resultado = $stmt->insert_id;

        $stmt->close();

        return $resultado;
    }
    function mostrarAcciones()
    {
        $sql = "SELECT id,nombre,descripcion FROM accion ";
        $resultado = $this->db->query($sql);

        return array("acciones" => $resultado->fetch_all(MYSQLI_ASSOC));
    }
    public function getAcciones()
    {
        $sql = "SELECT id, nombre, descripcion FROM accion";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function deleteAccion($id){
        $sql="DELETE FROM accion WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $resultado = $stmt->execute();

        $stmt->close();

        return $resultado;
    }
}
