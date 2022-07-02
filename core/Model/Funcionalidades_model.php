<?php
class Funcionalidades_model extends Base_model
{

    function __construct()
    {
        parent::__construct();
    }

    function addFuncionalidad($nombre, $descr)
    {
        $sql = "INSERT INTO funcionalidad ( nombre,descripcion,borrado) VALUES(?,?,0)";
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
    function mostrarFuncionalidades()
    {
        $sql = "SELECT id,nombre,descripcion FROM funcionalidad ";
        $resultado = $this->db->query($sql);

        return array("funcionalidades" => $resultado->fetch_all(MYSQLI_ASSOC));
    }
    public function getFuncionalidades()
    {
        $sql = "SELECT id, nombre, descripcion FROM funcionalidad";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function deleteFuncionalidad($id){
        $sql="DELETE FROM funcionalidad WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $resultado = $stmt->execute();

        $stmt->close();

        return $resultado;
    }
}
