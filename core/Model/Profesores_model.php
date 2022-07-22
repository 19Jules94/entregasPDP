<?php

class Profesores_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodos()
    {
        $sql = "SELECT
                    profesor.dni AS dni,
                    profesor.dedicacion AS dedicacion,
                    departamento.codigo AS codigo_departamento,
                    departamento.nombre AS nombre_departamento,
                    usuario.nombre AS nombre_usuario,
                    usuario.apellidos AS apellidos_usuario
                FROM
                    profesor,
                    usuario,
                    departamento
                WHERE
                    profesor.dni = usuario.dni AND profesor.id_DEPARTAMENTO = departamento.id;";

        $resultado = $this->db->query($sql);

        return array("profesores" => $resultado->fetch_all(MYSQLI_ASSOC));
    }
    function addProfesor($dni, $departamento, $dedicacion)
    {
        $sql = "INSERT INTO profesor (dni, id_DEPARTAMENTO, dedicacion, borrado) VALUES (?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sss", $dni, $departamento, $dedicacion);

        $stmt->execute();

        $resultado = $stmt->insert_id;

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

    function editProfesor($dni, $departamento, $dedicacion)
    {
        $sql = "UPDATE profesor SET id_DEPARTAMENTO=?, dedicacion=? WHERE dni=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sss", $departamento, $dedicacion, $dni);

        $resultado = $stmt->execute();

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar el profesor");
        }

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

    function deleteProfesor($dni)
    {
        $sql = "DELETE FROM profesor WHERE dni=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $dni);

        $resultado = $stmt->execute();

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar el profesor");
        }

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $resultado;
    }

    function show($dni)
    {
        $sql = "SELECT
                    profesor.dni AS dni,
                    profesor.dedicacion AS dedicacion,
                    profesor.id_DEPARTAMENTO AS departamento,
                    departamento.codigo AS codigo_departamento,
                    departamento.nombre AS nombre_departamento,
                    usuario.nombre AS nombre_usuario,
                    usuario.apellidos AS apellidos_usuario
                FROM
                    profesor,
                    usuario,
                    departamento
                WHERE
                    profesor.dni = usuario.dni AND profesor.id_DEPARTAMENTO = departamento.id AND profesor.dni = '".$dni."'";

        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar ese profesor");
        }

        return array("profesores" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    
    function getProfesores()
    {
        $sql = "SELECT
                    profesor.dni AS dni,
                    profesor.dedicacion AS dedicacion,
                    profesor.id_DEPARTAMENTO AS departamento,
                    departamento.codigo AS codigo_departamento,
                    departamento.nombre AS nombre_departamento,
                    usuario.nombre AS nombre_usuario,
                    usuario.apellidos AS apellidos_usuario
                FROM
                    profesor,
                    usuario,
                    departamento
                WHERE
                    profesor.dni = usuario.dni AND profesor.id_DEPARTAMENTO = departamento.id";

        $resultado = $this->db->query($sql);

        if($resultado->num_rows == 0){
            throw new ResourceNotFound("No se ha podido encontrar ese profesor");
        }

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function addPOD(array $profesores){

        $this->db->begin_transaction(MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
        $sql = "INSERT INTO profesor (dni, id_DEPARTAMENTO, dedicacion, borrado) VALUES (?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        foreach ($profesores as $profesor) {

            $departamento = $this->db->query("SELECT id FROM departamento WHERE codigo = '" . $profesor[4] . "'");
            if ($departamento) {
                $departamento = $departamento->fetch_all(MYSQLI_ASSOC);

                if (count($departamento) == 1) {

                    $departamentoId = $departamento[0]['id'];

                    $usuario = $this->db->query("SELECT dni FROM usuario WHERE dni = '" . $profesor[0] . "'");

                    if ($usuario) {
                        $usuario = $usuario->fetch_all(MYSQLI_ASSOC);

                        if (count($usuario) == 1) {
                            $stmt->bind_param("sss", $profesor[0], $departamentoId, $profesor[5]);
                            $stmt->execute();
                        }
                    }

                }
            }

        }

        $this->db->commit();

        $this->db->close();

        return true;
    }
}