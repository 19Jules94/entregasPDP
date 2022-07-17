<?php

class Rol_Usuario_model extends Base_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function addUsuarioRol($dni, $id_rol)
    {

        $sql = "INSERT INTO usuario_rol ( id_ROL, id_USUARIO) VALUES ( ? , ? )";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("is", $id_rol, $dni);
        $stmt->execute();

        switch ($stmt->errno) {
            case 0:
                return true;
            case 1062:
                $stmt->close();
                throw new DBException("4002");
            case 1452:
                $stmt->close();
                throw new DBException("4004");
            default:
                $stmt->close();
                return false;

        }
    }

    public function getUsuarios()
    {
        $sql = "SELECT dni, nombre, apellidos FROM usuario WHERE 1";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function getRoles()
    {
        $sql = "SELECT id, nombre FROM rol WHERE 1";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function mostrarTodos()
    {
        $sql = "SELECT usuario.nombre AS nombre_usuario, usuario.apellidos AS apellidos_usuario, usuario_rol.id_USUARIO AS usuario, usuario_rol.id_ROL as id_rol, rol.nombre as nombre_rol 
                FROM usuario_rol, rol, usuario 
                WHERE usuario_rol.id_ROL = rol.id AND usuario_rol.id_USUARIO = usuario.dni";

        $resultado = $this->db->query($sql);

        return array("roles_usuarios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function deleteUsuarioRol($dni, $id_rol)
    {
        $sql = "DELETE FROM usuario_rol WHERE id_ROL=? AND id_USUARIO=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("is", $id_rol, $dni);

        $resultado = $stmt->execute();

        $stmt->close();

        return $resultado;
    }



}