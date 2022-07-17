<?php
include_once './utils/ResourceNotFound.php';

class AAcademico_model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function addAAcademico($id, $anho)
    {
        $sql = "INSERT INTO anhoacademico (id, anho, borrado) VALUES (?,?, 0 )";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("ss",$id, $anho);

        $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $id;
    }

    public function mostrarTodos()
    {
        $sql = "SELECT id, anho FROM anhoacademico";

        $resultado = $this->db->query($sql);

        return array("anhos" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    public function getAAcademicos()
    {
        $sql = "SELECT id, anho FROM anhoacademico";

        $resultado = $this->db->query($sql);

        return  $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteAAcademico($id)
    {
        $sql = "DELETE FROM anhoacademico WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("s", $id);

        $resultado = $stmt->execute();

        if ($stmt->affected_rows == 0){
            $stmt->close();
            throw new ResourceNotFound("Año academico no encontrado");
        }

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $resultado;
    }

}