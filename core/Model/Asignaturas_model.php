<?php

include_once './utils/ResourceNotFound.php';

class Asignaturas_model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function mostrarTodas()
    {
        $sql = "SELECT a.id, a.`id_TITULACION`, t.`nombre` as `nombre_titulacion`, a.`id_ANHOACADEMICO`, a.`id_DEPARTAMENTO`, 
        d.`nombre` as `nombre_departamento`, COALESCE(a.`id_PROFESOR`, 'No tiene') as profesor, COALESCE(CONCAT( u.`nombre`,' ',U.`apellidos`), 'No tiene') AS `nombre_profesor`, 
        a.`codigo`, a.`nombre`, a.`contenido`, a.`creditos`, a.`tipo`, a.`horas`, a.`cuatrimestre`

        FROM `asignatura` AS `a`

        LEFT JOIN `titulacion` as `t`
        ON t.`id`=a.`id_TITULACION`
        
        LEFT JOIN `usuario` as `u`
        ON u.`dni`=a.`id_PROFESOR`

        LEFT JOIN `departamento` as `d`
        ON d.`id`=a.`id_DEPARTAMENTO`";

        $resultado = $this->db->query($sql);

        return array("asignaturas" => $resultado->fetch_all(MYSQLI_ASSOC));
    }


    function addAsignatura($nombre, $codigo, $contenido, $creditos, $tipo, $horas, $cuatrimestre,
                 $titulacion, $anhoacademico, $departamento, $profesor)
    {

        $sql = "INSERT INTO `asignatura`(`id_TITULACION`, `id_ANHOACADEMICO`, `id_DEPARTAMENTO`, 
        `id_PROFESOR`, `codigo`, `nombre`, `contenido`, `creditos`, `tipo`, `horas`, `cuatrimestre`, `borrado`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sssssssssss", $titulacion, $anhoacademico, $departamento, $profesor,
            $codigo, $nombre, $contenido, $creditos, $tipo, $horas, $cuatrimestre);

        $stmt->execute();

        $resultado = $stmt->insert_id;

        if ($stmt->errno == 1452) {
            $stmt->close();
            throw new DBException("4004");
        }

        if ($stmt->errno == 1451) {
            $stmt->close();
            throw new DBException("4001");
        }

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $resultado;
    }

    function editAsignatura($id, $nombre, $codigo, $contenido, $creditos, $tipo, $horas, $cuatrimestre,
                  $titulacion, $anhoacademico, $departamento, $profesor)
    {
        $sql = "UPDATE asignatura SET `id_TITULACION`=?, `id_ANHOACADEMICO`=?, `id_DEPARTAMENTO`=?, 
        `id_PROFESOR`=?, `codigo`=?, `nombre`=?, `contenido`=?, `creditos`=?, `tipo`=?, `horas`=?, `cuatrimestre`=?, borrado=0 WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sssssssssssi", $titulacion, $anhoacademico, $departamento, $profesor,
            $codigo, $nombre, $contenido, $creditos, $tipo, $horas, $cuatrimestre, $id);

        $resultado = $stmt->execute();

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar la asignatura");
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

    function deleteAsignatura($id)
    {
        $sql = "DELETE FROM asignatura WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar la asignatura");
        }

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $resultado;
    }

    function show($id)
    {
        $sql = "SELECT a.`id`, a.`id_TITULACION` as titulacion, t.`nombre` as `nombre_titulacion`, an.`anho` as `anhoacademico`, a.`id_DEPARTAMENTO`
        as `departamento`, d.`nombre` as `nombre_departamento`, COALESCE(a.`id_PROFESOR`, 'No tiene') as profesor,COALESCE(CONCAT( u.`nombre`,' ',U.`apellidos`), 'No tiene')  AS `nombre_profesor`, 
        a.`codigo`, a.`nombre`, a.`contenido`, a.`creditos`, a.`tipo`, a.`horas`, a.`cuatrimestre` 
        
        FROM `asignatura` AS `a`
        
        LEFT JOIN `titulacion` as `t`
        ON t.`id`=a.`id_TITULACION`
        
        LEFT JOIN `usuario` as `u`
        ON u.`dni`=a.`id_PROFESOR`

        LEFT JOIN `departamento` as `d`
        ON d.`id`=a.`id_DEPARTAMENTO`

        LEFT JOIN `anhoacademico` as `an`
        ON a.`id_ANHOACADEMICO`=an.`id`
        
        WHERE a.id = '" . $id . "'";

        $resultado = $this->db->query($sql);

        if ($resultado->num_rows == 0) {
            throw new ResourceNotFound("No se ha podido encontrar esa asignatura");
        }

        return array("asignaturas" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getAsignaturas()
    {
        $sql = "SELECT a.`id`, a.`id_TITULACION` as titulacion, t.`nombre` as `nombre_titulacion`, an.`anho` as `anhoacademico`, a.`id_DEPARTAMENTO`
        as `departamento`, d.`nombre` as `nombre_departamento`, COALESCE(a.`id_PROFESOR`, 'No tiene') as profesor,COALESCE(CONCAT( u.`nombre`,' ',U.`apellidos`), 'No tiene'), 
        a.`codigo`, a.`nombre`, a.`contenido`, a.`creditos`, a.`tipo`, a.`horas`, a.`cuatrimestre` 
        
        FROM `asignatura` AS `a`, `titulacion` as `t`,`profesor` as `p`,`usuario` as `u`, `departamento` as `d`, `anhoacademico` as `an`
        WHERE d.`id`=a.`id_DEPARTAMENTO`
        AND t.`id`=a.`id_TITULACION`
        AND u.`dni`=a.`id_PROFESOR` 
        AND p.`dni`=u.`dni` 
        AND an.`id`=a.`id_ANHOACADEMICO`";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function addPDA(array $informacionDepurada)
    {


        $asignaturas = $informacionDepurada['asignaturas'];
        $cod_titulacion = $informacionDepurada['cod_titulacion'];
        $anho_academico = $informacionDepurada['anho_academico'];


        $this->db->begin_transaction(MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);


        $resultado = $this->db->query("SELECT id FROM titulacion WHERE codigo = '" . $cod_titulacion . "' AND id_ANHOACADEMICO = '" . $anho_academico . "'");

        if ($resultado) {
            $resultado = $resultado->fetch_all(MYSQLI_ASSOC);

            if (count($resultado) == 1) {

                $idTitulacion = $resultado[0]['id'];

                $sql = "INSERT INTO `asignatura`(`id_TITULACION`, `id_ANHOACADEMICO`, `id_DEPARTAMENTO`
                        , `codigo`, `nombre`, `contenido`, `creditos`, `tipo`, `horas`, `cuatrimestre`, `borrado`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

                $stmt = $this->db->prepare($sql);


                foreach ($asignaturas as $asignatura) {

                    $resultadoDep = $this->db->query("SELECT id FROM departamento WHERE codigo = '" . $asignatura['departamento'] . "'")->fetch_all(MYSQLI_ASSOC);
                    $contenido = "";
                    if (count($resultadoDep) == 1) {

                        $stmt->bind_param("ssssssssss",
                            $idTitulacion,
                            $anho_academico,
                            $resultadoDep[0]['id'],
                            $asignatura['codigo'],
                            $asignatura['nombre'],
                            $contenido,
                            $asignatura['creditos'],
                            $asignatura['tipo'],
                            $asignatura['horas'],
                            $asignatura['cuatrimestre']);

                        $stmt->execute();

                    }

                }

            }
        }

        $this->db->commit();

        $this->db->close();

        return true;
    }

}