<?php

include_once './Model/Departamentos_model.php';
include_once './Model/Profesores_model.php';
include_once './Model/Usuarios_model.php';
include_once './utils/ValidationException.php';

class POD_service
{
    private $DEPARTAMENTOS_MODEL;
    private $PROFESORES_MODEL;
    private $USUARIOS_MODEL;

    function __construct()
    {
        $this->DEPARTAMENTOS_MODEL = new Departamentos_Model();
        $this->PROFESORES_MODEL = new Profesores_Model();
        $this->USUARIOS_MODEL = new Usuarios_Model();
    }

    public function addPDF($pages)
    {
        $executePOD=true;

        $fullPOD = [];

        foreach ($pages as $page) {
            $fullPOD = array_merge($fullPOD, $page->getTextArray());
        }

        $parsedContent=$this->addPage($fullPOD);

        if(!$this->DEPARTAMENTOS_MODEL->addPOD($parsedContent[0])){
           $executePOD=false;
        }

        if(!$this->USUARIOS_MODEL->addPOD($parsedContent[1])){
            $executePOD=false;
        }

        if(!$this->PROFESORES_MODEL->addPOD($parsedContent[1])){
            $executePOD=false;
        }


        return $executePOD;
    }

    public function addPage($lineas): array
    {
        $departamentos=[];
        $profesores=[];

        $nombreCentro = substr($lineas[7], 6, strlen($lineas[7]));
        $departments = array();

        $countLineas = 0;
        foreach ($lineas as $linea) {
            $countLineas = $countLineas + 1;
            $codDepartamento = substr($linea, 1, 6);
            if (preg_match("/^[A-Z][0-9]{2}[a-z][0-9]{2}$/", $codDepartamento) > 0) {
                $departments[] = $countLineas;
            }
        }

        $departments[] = count($lineas);
        $count = count($departments);

        foreach ($departments as $posDep => $d) {
            if (--$count <= 0) {
                break;
            }
            $s2 = $departments[$posDep + 1];
            $length_asignatura = $s2 - $d;

            $lineasDep = array_slice($lineas, $d - 1, $length_asignatura);

            $codDepartamento = substr($lineasDep[0], 1, 6);
            $nombreDepartamento = substr($lineasDep[0], 9, strlen($lineasDep[0]));
            $departamento = array($codDepartamento, $nombreDepartamento, $nombreCentro);
            array_push($departamentos,$departamento);

            $search_asignatura = "";
            $breakpoint_asignaturas = array();
            $countLineas = 0;

            foreach ($lineasDep as $lineaDep) {
                $countLineas = $countLineas + 1;

                //echo("$lineaDep-$countLineas\n");
                $search_asignatura .= $lineaDep;
                if (preg_match("/[(][A][0-9]{4}[)]/", $search_asignatura) == 1) {
                    $breakpoint_asignaturas[] = $countLineas - 6;
                    $search_asignatura = "";
                }
            }
            $breakpoint_asignaturas[] = count($lineasDep);

            $count_asig = count($breakpoint_asignaturas);

            foreach ($breakpoint_asignaturas as $posDep => $d) {
                if (--$count_asig <= 0) {
                    break;
                }
                $s2 = $breakpoint_asignaturas[$posDep + 1];
                $length_asignatura = $s2 - $d;

                $array_asignatura=array_slice($lineasDep, $d - 2, $length_asignatura);


                $countLineas = 0;
                $flag_codigo = false;
                $cod_asignatura = "";
                $nombre_asignatura = "";

                foreach ($array_asignatura as $lineaDep) {
                    $countLineas = $countLineas + 1;

                    if ($countLineas == 1) continue;

                    if ($lineaDep == "Documento") {


                        $lineasDepDocs=array_slice($array_asignatura, $countLineas, count($array_asignatura));

                        $flag_inicio_tabla = false;
                        $flag_nome = false;
                        $nombre_profesor = " ";
                        $dni_profesor = "";
                        foreach ($lineasDepDocs as $lineaDoc) {


                            if ($flag_nome) {
                                $nombre_profesor .= $lineaDoc;

                                if (preg_match("/([a-zA-ZñÑáãéíóúÁÉÍÓÚ\s.]*)((TC)|(P[0-6]))(O[0-9]+)/", $nombre_profesor, $codigo)) {
                                    $dedicacion = $codigo[2];
                                    $nombre = $codigo[1];
                                    $flag_nome = false;

                                    $nombre_split=$this->addProfesor($nombre);
                                    $profesor=array($dni_profesor,$nombre_split[0],$nombre_split[1],"$nombre_split[0].@uvigo.es", $codDepartamento,$dedicacion);
                                    array_push($profesores,$profesor);
                                    $nombre_profesor = "";
                                }
                            }

                            if ($flag_inicio_tabla && preg_match("/[0-9A-Z]{1}[0-9]{7}[A-Z]/", $lineaDoc, $codigo) == 1) {
                                $dni_profesor = $codigo[0];
                                $flag_inicio_tabla = true;
                                $flag_nome = true;
                            }

                            //empieza la tabla
                            if ("$lineaDoc" == "Alumnos") {
                                $flag_inicio_tabla = true;
                            }


                        }

                        $flag_codigo = false;
                    }

                    if ($flag_codigo) {
                        $nombre_asignatura .= $lineaDep;
                    } else {
                        $cod_asignatura .= $lineaDep;
                        if (preg_match("/[(][A][0-9]{4}[)]/", $cod_asignatura, $codigo) == 1) {
                            $cod_asignatura = substr($codigo[0], 1, 5);
                            $flag_codigo = true;
                        }
                    }

                }
            }
        }

        $toret=array($departamentos,$profesores);

        return $toret;
    }


    private function addProfesor( $nombre): array
    {
        $nombre_split = preg_split("/[\s,]+/", $nombre);
        if (strlen($nombre_split[0]) == 0) {
            $start = 1;
        } else {
            $start = 0;
        }

        $nombre_final="";
        $apellidos_final="";

        if (count($nombre_split) > 4) {
            $posiciones_nombre = 2;
            $posiciones_apellidos = count($nombre_split) - $posiciones_nombre;

            for ($i = $start; $i <= $posiciones_nombre; $i++) {
                $nombre_final.=$nombre_split[$i]." ";
            }

            for ($posiciones_apellidos; $i < count($nombre_split); $i++) {
                $apellidos_final.=$nombre_split[$i]." ";
            }

        } else {
            $posiciones_nombre = 1;
            $posiciones_apellidos = count($nombre_split) - $posiciones_nombre;

            for ($i = $start; $i <= $posiciones_nombre; $i++) {
                $nombre_final.=$nombre_split[$i]." ";

            }

            for ($posiciones_apellidos; $i < count($nombre_split); $i++) {
                $apellidos_final.=$nombre_split[$i]." ";
            }

        }

        return array($nombre_final,$apellidos_final);
    }

}