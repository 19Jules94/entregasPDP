<?php

include_once './Controller/Basic_Controller.php';
include_once './Service/PDA_service.php';

class PDA_controller extends Basic_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->controller();
    }

    private function controller()
    {
        if (!$this->IS_LOGGED) {
            $this->unauthorized();
        } else {
            if ($this->canUseAction("PDA", "ADD")) {

                $dir_subida = './Uploads/';

                if (count($_FILES) == 1
                    && array_key_exists('file', $_FILES)
                    && array_key_exists('name', $_FILES['file'])
                    && array_key_exists('type', $_FILES['file'])
                    && array_key_exists('tmp_name', $_FILES['file'])
                    && $_FILES['file']['type'] == 'application/pdf'
                    && preg_match("/^.+\.pdf$/", $_FILES['file']['name'])
                ) {
                    $fichero_subido = $dir_subida . basename($_FILES['file']['name']);

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {
                        $resultado = $this->parserPDA($fichero_subido);
                        $this->TodoOK($resultado);
                        unlink($fichero_subido);
                    } else {
                        $this->errorSubirArchivo("Error interno en la subida del archivo");
                    }
                } else {
                    $this->NoEncontrado("Se debe enviarun 'file' de tipo PDF (type=application/pdf y extension=.pdf)");
                }


            } else {
                $this->forbidden("PDA", "ADD");
            }
        }
    }

    private function parserPDA($ruta_archivo)
    {
        $PDA_Service = new PDA_service();
        return $PDA_Service->add($ruta_archivo);
    }


}