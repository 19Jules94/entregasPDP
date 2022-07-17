<?php
include_once './utils/ResourceNotFound.php';

class Horarios_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }
    function mostrarTodos()
    {
        $sql = "SELECT horario.id AS id, horario.fecha AS fecha, horario.hora_inicio AS hora_inicio, horario.hora_fin AS hora_fin, horario.asistencia AS asistencia,
        horario.dia AS dia, anhoacademico.anho AS anho, profesor.dni AS profesor, espacio.nombre AS espacio, grupo.nombre AS grupo, 
        asignatura.nombre AS asignatura, titulacion.nombre AS titulacion
        FROM horario, anhoacademico, profesor, espacio, grupo, asignatura, titulacion 
        WHERE horario.id_ANHOACADEMICO = anhoacademico.id AND horario.id_PROFESOR = profesor.dni AND horario.id_ESPACIO = espacio.id AND horario.id_GRUPO = grupo.id 
        AND horario.id_ASIGNATURA = asignatura.id AND horario.id_TITULACION = titulacion.id";

        $resultado = $this->db->query($sql);

        return array("horarios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function addHorario($id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $fecha, $hora_inicio, $hora_fin, $asistencia, $dia)
    {

        $this->validateHours($hora_inicio, $hora_fin, $id_ESPACIO, $fecha, $id_GRUPO, $id_PROFESOR, null);

        $sql = "INSERT INTO horario (id_ANHOACADEMICO, id_PROFESOR, id_ESPACIO, id_GRUPO, id_ASIGNATURA, id_TITULACION, fecha, hora_inicio, hora_fin, asistencia, dia, borrado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $date = date('Y-m-d', strtotime($fecha));
        $stmt->bind_param("isiiiisssss", $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $date, $hora_inicio, $hora_fin, $asistencia, $dia);

        $stmt->execute();

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->errno == 1452) {
            $stmt->close();
            throw new DBException("4004");
        }

        $resultado = $stmt->insert_id;

        $stmt->close();

        return $resultado;
    }

    function editHorario($id, $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $fecha, $hora_inicio, $hora_fin, $asistencia, $dia)
    {
        $this->validateHours($hora_inicio, $hora_fin, $id_ESPACIO, $fecha, $id_GRUPO, $id_PROFESOR, $id);

        $sql = "UPDATE horario SET id_ANHOACADEMICO=?, id_PROFESOR=?, id_ESPACIO=?, id_GRUPO=?, id_ASIGNATURA=?, id_TITULACION=?, fecha=?, hora_inicio=?, hora_fin=?, asistencia=?, dia=?, borrado=0
                WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $date = date('Y-m-d', strtotime($fecha));
        $stmt->bind_param("isiiiisssssi", $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $date, $hora_inicio, $hora_fin, $asistencia, $dia, $id);

        $resultado = $stmt->execute();

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->errno == 1452) {
            $stmt->close();
            throw new DBException("4004");
        }

        if ($stmt->affected_rows == 0) {
            throw new ResourceNotFound("No se ha podido encontrar el horario");
        }

        $stmt->close();
        return $resultado;
    }

    function deleteHorario($id)
    {
        $sql = "DELETE FROM horario WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);

        $resultado = $stmt->execute();

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->affected_rows == 0) {
            throw new ResourceNotFound("No se ha podido encontrar el horario");
        }

        $stmt->close();

        return $resultado;
    }

    function asistencia($id,$asistencia){

        $sql = "UPDATE horario SET asistencia=? WHERE id=? ";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("si", $asistencia, $id);

        $resultado = $stmt->execute();

        if ($stmt->affected_rows == 0) {
            throw new ResourceNotFound("No se ha podido encontrar el horario de clase");
        }
        $stmt->close();
        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT horario.id AS id, 
        horario.fecha AS fecha, 
        horario.hora_inicio AS hora_inicio, 
        horario.hora_fin AS hora_fin, 
        horario.asistencia AS asistencia,
        horario.dia AS dia, 
        anhoacademico.anho AS anho, 
        usuario.dni AS profesor,  
        CONCAT(usuario.nombre,' ',usuario.apellidos) AS profesor_nombre,  
        espacio.id AS espacio, 
        espacio.nombre AS espacio_nombre, 
        grupo.id AS grupo, 
        grupo.nombre AS grupo_nombre, 
        asignatura.id AS asignatura, 
        asignatura.nombre AS asignatura_nombre, 
        titulacion.id AS titulacion,
        titulacion.nombre AS titulacion_nombre

        FROM horario, anhoacademico, usuario, espacio, grupo, asignatura, titulacion 

        WHERE horario.id_ANHOACADEMICO = anhoacademico.id 
        AND horario.id_PROFESOR = usuario.dni 
        AND horario.id_ESPACIO = espacio.id 
        AND horario.id_GRUPO = grupo.id 
        AND horario.id_ASIGNATURA = asignatura.id 
        AND horario.id_TITULACION = titulacion.id 
        AND horario.id = '" . $id . "'";
        $resultado = $this->db->query($sql);

        if ($resultado->num_rows == 0) {
            throw new ResourceNotFound("No se ha podido encontrar ese horario");
        }

        return array("horarios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function validateHours($hora_inicio, $hora_fin, $espacio, $fecha, $grupo, $profesor, $id)
    {
 
        if ($id) {
            $sql_espacios = "SELECT horario.id AS id, horario.hora_inicio AS hora_inicio,
            horario.hora_fin AS hora_fin, espacio.id AS espacio
            FROM horario, espacio
            WHERE horario.id_ESPACIO = '" . $espacio . "' and horario.fecha='" . $fecha . "'
            and not horario.id ='" . $id . "'";
    
            $sql_grupos = "SELECT horario.id AS id, horario.hora_inicio AS hora_inicio,
            horario.hora_fin AS hora_fin 
            FROM horario, grupo 
            WHERE horario.id_GRUPO = '" . $grupo . "' and horario.fecha='" . $fecha . "'
            and NOT horario.id ='" . $id . "'";
    
            $sql_profesores = "SELECT horario.id AS id, horario.hora_inicio AS hora_inicio,
            horario.hora_fin AS hora_fin 
            FROM horario, grupo 
            WHERE horario.id_PROFESOR = '" . $profesor . "' and horario.fecha='" . $fecha . "'
            and NOT horario.id ='" . $id . "'";

         }else{

            $sql_espacios = "SELECT horario.id AS id, horario.hora_inicio AS hora_inicio,
            horario.hora_fin AS hora_fin, espacio.id AS espacio
            FROM horario, espacio
            WHERE horario.id_ESPACIO = '" . $espacio . "' and horario.fecha='" . $fecha . "'";
    
            $sql_grupos = "SELECT horario.id AS id, horario.hora_inicio AS hora_inicio,
            horario.hora_fin AS hora_fin 
            FROM horario, grupo 
            WHERE horario.id_GRUPO = '" . $grupo . "' and horario.fecha='" . $fecha . "'";
    
            $sql_profesores = "SELECT horario.id AS id, horario.hora_inicio AS hora_inicio,
            horario.hora_fin AS hora_fin 
            FROM horario, grupo 
            WHERE horario.id_PROFESOR = '" . $profesor . "' and horario.fecha='" . $fecha . "'";
         }


        $profesores = $this->db->query($sql_profesores);
        $espacios = $this->db->query($sql_espacios);
        $grupos = $this->db->query($sql_grupos);

        try {
            $this->calcHours($espacios, $hora_inicio, $hora_fin);
        } catch (DBException $e) {
            throw new DBException("40011");
        }

        try {
            $this->calcHours($grupos, $hora_inicio, $hora_fin);
        } catch (DBException $e) {
            throw new DBException("40012");
        }

        try {
            $this->calcHours($profesores, $hora_inicio, $hora_fin);
        } catch (DBException $e) {
            throw new DBException("40013");
        }
    }

    function calcHours($horarios, $hora_inicio, $hora_fin)
    {

        foreach ($horarios as $horario) {
            if (
                //Hora de inicio coincide con otra clase de esta entidad
                $hora_inicio >= $horario['hora_inicio']
                && $hora_inicio < $horario['hora_fin']
                ||
                //Hora de final coincide con otra clase de de esta entidad
                $hora_fin >= $horario['hora_inicio']
                && $hora_fin < $horario['hora_fin']
                ||
                //Hay una clase de esta entidad en el medio de las dos horas
                $hora_inicio < $horario['hora_inicio']
                && $hora_fin > $horario['hora_fin']
            ) {
                throw new DBException("4001");
            }
        }
    }

    public function getTutorias($DNI)
    {
        $sql = "SELECT horario.id AS id, horario.fecha AS fecha, horario.hora_inicio AS hora_inicio, horario.hora_fin AS hora_fin, horario.asistencia AS asistencia,
        horario.dia AS dia, anhoacademico.anho AS anho, profesor.dni AS profesor, espacio.nombre AS espacio, grupo.nombre AS grupo, 
        asignatura.nombre AS asignatura, titulacion.nombre AS titulacion
        FROM horario, anhoacademico, profesor, espacio, grupo, asignatura, titulacion 
        WHERE horario.id_ANHOACADEMICO = anhoacademico.id AND horario.id_PROFESOR = profesor.dni AND horario.id_ESPACIO = espacio.id AND horario.id_GRUPO = grupo.id 
        AND horario.id_ASIGNATURA = asignatura.id AND horario.id_TITULACION = titulacion.id  AND horario.id_PROFESOR = '".$DNI."'";

        $resultado = $this->db->query($sql);

        return array("horarios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }
}
