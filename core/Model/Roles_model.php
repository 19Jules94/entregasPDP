<?php

class Roles_model extends Base_model{

    function __construct()
    {
        parent::__construct();
    }

    function mostrarRoles(){

        $sql = "SELECT id, nombre FROM rol";

        $resultado = $this->db->query($sql);

        return array("roles" => $resultado->fetch_all(MYSQLI_ASSOC));
    }
    function addRol($nombre)
    {

        // Perform a query, check for error
 
        $sql = "INSERT INTO rol ( nombre, borrado) VALUES ( ? , 0 )";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
 
        $resultado = $stmt->insert_id;
                
        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

         
        return $resultado;
    }

    function deleteRol($id)
    {

        $sql = "DELETE FROM rol WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        $stmt->close();

        return $resultado;
    }

    public function getRoles()
    {
        $sql = "SELECT id, nombre FROM rol";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
