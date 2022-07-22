<?php

use Smalot\PdfParser\Parser;

include_once './Model/Asignaturas_model.php';


class PDA_service
{

    private $ASIGNATURAS_M;

    function __construct()
    {
        $this->ASIGNATURAS_M = new Asignaturas_model();
    }

    function add($ruta_archivo)
    {
        
        $content = $this->parser($ruta_archivo);

      
        $informacion = $this->getInfo($content);

     
        $informacionDepurada = $this->prepareInfo($informacion);

      
        return $this->ASIGNATURAS_M->addPDA($informacionDepurada);

    }


   
    private function parser($ruta_archivo)
    {

        $parser = new Parser();
        $pdf = $parser->parseFile($ruta_archivo);

        $pages = $pdf->getPages();

        try {
            $array = array();
            foreach ($pages as $page) {
                $array = array_merge($array, $page->getTextArray());
            }
        } catch (Exception $e) {

        }

        return $array;
    }


    private function getInfo(array $content)
    {
        $cod_titulacion = null;
        $nombre_titulacion = null;
        $anho_academico = null;

        $asignaturas = array();

        $cod_asignatura = null;
        $nom_asignatura = null;
        $temp_nom_asignatura = '';
        $tip_asignatura = null;
        $departamento = null;
        $area = null;
        $cuatrimestre = null;
        $creditos = null;
        $n_alumnos_nuevos = null;
        $n_alumnos_repetidores = null;
        $n_alumnos_efectivos = null;
        $n_alumnos_le = null;
        $ha = null;
        $hb = null;
        $hc = null;
        $ga = null;
        $gb = null;
        $gc = null;
        $horas_matri = null;
        $horas_impar = null;
        $pod_a = null;
        $pod_b = null;
        $pod_c = null;
        $tmg = null;
        $presen = null;


        $bandera = 0;
        foreach ($content as $item) {

            if (preg_match("/^.+Ver primario.+$/", $item) || preg_match("/^Sen docencia$/", $item)) {
                $bandera = 2;

                $cod_asignatura = null;
                $nom_asignatura = null;
                $temp_nom_asignatura = '';
                $tip_asignatura = null;
                $departamento = null;
                $area = null;
                $cuatrimestre = null;
                $creditos = null;
                $n_alumnos_nuevos = null;
                $n_alumnos_repetidores = null;
                $n_alumnos_efectivos = null;
                $n_alumnos_le = null;
                $ha = null;
                $hb = null;
                $hc = null;
                $ga = null;
                $gb = null;
                $gc = null;
                $horas_matri = null;
                $horas_impar = null;
                $pod_a = null;
                $pod_b = null;
                $pod_c = null;
                $tmg = null;
                $presen = null;
            }

            switch ($bandera) {
                case 0:
                    if (preg_match("/^.+[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}[0-9]{2}.+$/", $item)) {
                        $temp = explode(')', $item);
                        $cod_titulacion = explode('(', $temp[0])[1];
                        $nombre_titulacion = trim($temp[1]);
                        $bandera = 1;
                    }
                    break;
                case 1:
                    if (preg_match("/^[0-9]{4}[\/][0-9]{4}$/", $item)) {
                        $anho_academico = $item;
                        $bandera = 2;
                    }
                    break;
                case 2:
                    if (preg_match("/^[A-Z][0-9]{6}$/", $item)) {
                        $cod_asignatura = $item;
                        $bandera = 3;
                    }
                    break;
                case 3:
                    if (preg_match("/^(FB)|(OB)|(OP)$/", $item)) {
                        $tip_asignatura = $item;
                        $nom_asignatura = $temp_nom_asignatura;
                        $temp_nom_asignatura = '';
                        $bandera = 4;
                    } else {
                        $temp_nom_asignatura = $temp_nom_asignatura . ' ' . $item;
                    }
                    break;
                case 4:
                    if (preg_match("/^[A-Z][0-9]{2}[a-z][0-9]{2}$/", $item)) {
                        $departamento = $item;
                        $bandera = 5;
                    }
                    break;
                case 5:
                    if (preg_match("/^[A-Z][0-9]{4}$/", $item)) {
                        $area = $item;
                        $bandera = 6;
                    }
                    break;
                case 6:
                    if (preg_match("/^([0-9]SG)|(ANG)$/", $item)) {
                        $cuatrimestre = $item;
                        $bandera = 7;
                    }
                    break;
                case 7:
                    if (preg_match("/^[0-9]+.[0-9]+$/", $item)) {
                        $creditos = $item;
                        $bandera = 8;
                    }
                    break;
                case 8:
                    if (preg_match("/^[0-9]+$/", $item)) {
                        $n_alumnos_nuevos = $item;
                        $bandera = 9;
                    }
                    break;
                case 9:
                    if (preg_match("/^[0-9]+$/", $item)) {
                        $n_alumnos_repetidores = $item;
                        $bandera = 10;
                    }
                    break;
                case 10:
                    if (preg_match("/^[0-9]+$/", $item)) {
                        $n_alumnos_efectivos = $item;
                        $bandera = 11;
                    }
                    break;
                case 11:
                    if (preg_match("/^[0-9]+$/", $item)) {
                        $n_alumnos_le = $item;
                        $bandera = 12;
                    }
                    break;
                case 12:
                    if (preg_match("/^[0-9]+.[0-9]+$/", $item)) {
                        $ha = $item;
                        $bandera = 13;
                    }
                    break;
                case 13:
                    if (preg_match("/^[0-9]+.[0-9]+$/", $item)) {
                        $hb = $item;
                        $bandera = 14;
                    }
                    break;
                case 14:
                    if (preg_match("/^[0-9]+.[0-9]+$/", $item)) {
                        $hc = $item;
                        $bandera = 15;
                    }
                    break;
                case 15:
                    if (preg_match("/^[0-9]+.[0-9]+$/", $item)) {
                        $ga = $item;
                        $bandera = 16;
                    }
                    break;
                case 16:
                    if (preg_match("/^[0-9]+.[0-9]+$/", $item)) {
                        $gb = $item;
                        $bandera = 17;
                    }
                    break;
                case 17:
                    if (preg_match("/^[0-9]+.[0-9]+$/", $item)) {
                        $gc = $item;
                        $bandera = 18;
                    }
                    break;
                case 18:
                    if (preg_match("/^[0-9]*,*[0-9]+.[0-9]+$/", $item)) {
                        $horas_matri = $item;
                        $bandera = 19;
                    }
                    break;
                case 19:
                    if (preg_match("/^[0-9]*,*[0-9]+.[0-9]+$/", $item)) {
                        $horas_impar = $item;
                        $bandera = 20;
                    }
                    break;
                case 20:
                    if (preg_match("/^[0-9]*,*[0-9]+.[0-9]+$/", $item)) {
                        $pod_a = $item;
                        $bandera = 21;
                    }
                    break;
                case 21:
                    if (preg_match("/^[0-9]*,*[0-9]+.[0-9]+$/", $item)) {
                        $pod_b = $item;
                        $bandera = 22;
                    }
                    break;
                case 22:
                    if (preg_match("/^[0-9]*,*[0-9]+.[0-9]+$/", $item)) {
                        $pod_c = $item;
                        $bandera = 23;
                    }
                    break;
                case 23:
                    if (preg_match("/^[0-9]*,*[0-9]+.[0-9]+$/", $item)) {
                        $tmg = $item;
                        $bandera = 24;
                    }
                    break;
                case 24:
                    if (preg_match("/^[0-9]*,*[0-9]+.[0-9]+$/", $item)) {
                        $presen = $item;
                        $bandera = 2;

                        $asignatura = array(
                            "codigo" => $cod_asignatura,
                            "nombre" => $nom_asignatura,
                            "tipo" => $tip_asignatura,
                            "departamento" => $departamento,
                            "cuatrimestre" => $cuatrimestre,
                            "area" => $area,
                            "creditos" => $creditos,
                            "n_alumnos_nuevos" => $n_alumnos_nuevos,
                            "n_alumnos_repetidores" => $n_alumnos_repetidores,
                            "n_alumnos_efectivos" => $n_alumnos_efectivos,
                            "n_alumnos_le" => $n_alumnos_le,
                            "ha" => $ha,
                            "hb" => $hb,
                            "hc" => $hc,
                            "ga" => $ga,
                            "gb" => $gb,
                            "gc" => $gc,
                            "horas_matri" => $horas_matri,
                            "horas_impar" => $horas_impar,
                            "pod_a" => $pod_a,
                            "pod_b" => $pod_b,
                            "pod_c" => $pod_c,
                            "tmg" => $tmg,
                            "presen" => $presen
                        );
                        array_push($asignaturas, $asignatura);

                        $cod_asignatura = null;
                        $nom_asignatura = null;
                        $temp_nom_asignatura = '';
                        $tip_asignatura = null;
                        $departamento = null;
                        $area = null;
                        $cuatrimestre = null;
                        $creditos = null;
                        $n_alumnos_nuevos = null;
                        $n_alumnos_repetidores = null;
                        $n_alumnos_efectivos = null;
                        $n_alumnos_le = null;
                        $ha = null;
                        $hb = null;
                        $hc = null;
                        $ga = null;
                        $gb = null;
                        $gc = null;
                        $horas_matri = null;
                        $horas_impar = null;
                        $pod_a = null;
                        $pod_b = null;
                        $pod_c = null;
                        $tmg = null;
                        $presen = null;
                    }
                    break;
                case -1:
                    break;
            }
        }


        $toret = array(
            "cod_titulacion" => $cod_titulacion,
            "nombre_titulacion" => $nombre_titulacion,
            "anho_academico" => $anho_academico,
            "asignaturas" => $asignaturas
        );

        return $toret;
    }

    private function prepareInfo(array $informacion)
    {

        $asignaturas = array();

        foreach ($informacion['asignaturas'] as $item) {
            $asignatura = array();

            $codigo = $informacion['cod_titulacion'] . substr($item['codigo'], 4, 3);
            $asignatura['codigo'] = $codigo;

            $asignatura['nombre'] = $item['nombre'];
            $asignatura['tipo'] = $item['tipo'];
            $asignatura['creditos'] = $item['creditos'];
            $asignatura['horas'] = $item['horas_impar'];
            $asignatura['departamento'] = $item['departamento'];
            $asignatura['cuatrimestre'] = substr($item['cuatrimestre'], 0, 1);

            array_push($asignaturas, $asignatura);
        }

        $anho_academico = str_replace('/', '', $informacion['anho_academico']);

        $toret = array(
            "cod_titulacion" => $informacion['cod_titulacion'],
            "nombre_titulacion" => $informacion['nombre_titulacion'],
            "anho_academico" => $anho_academico,
            "asignaturas" => $asignaturas
        );

        return $toret;
    }


}