<?php
include_once './utils/DBException.php';


class Permisos_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodos()
    {
        $sql = "SELECT rol.id as \"rol_id\", rol.nombre as \"rol\", funcionalidad.id as \"func_id\", funcionalidad.nombre AS \"funcionalidad\"
        , accion.id AS \"accion_id\", accion.nombre AS \"accion\" FROM rol_permiso
        left join rol on rol_permiso.id_ROL = rol.id
        left join funcionalidad on rol_permiso.id_FUNCIONALIDAD = funcionalidad.id
        left join accion on rol_permiso.id_ACCION = accion.id";

        $resultado = $this->db->query($sql);
        return array("Permisos" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addPermiso($rol, $funcionalidad, $accion)
    {
        $sql = "INSERT INTO rol_permiso(id_ROL,id_FUNCIONALIDAD,id_ACCION)values(?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $rol, $funcionalidad, $accion);
        $stmt->execute();
        $resultado = $stmt->num_rows;

        if ($stmt->errno == 1452) {
            $stmt->close();
            throw new DBException("4004");
        }
        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();
        return $resultado;
    }

    function deletePermiso($rol, $funcionalidad, $accion)
    {

        $sql = "DELETE FROM rol_permiso WHERE id_ROL=? AND id_FUNCIONALIDAD=? AND id_ACCION=? ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $rol, $funcionalidad, $accion);
        $resultado = $stmt->execute();

        if($stmt->affected_rows==0){
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar el permiso");
        }


        $stmt->close();

        return $resultado;
    }
}
