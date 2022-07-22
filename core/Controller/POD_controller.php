<?php

use Smalot\PdfParser\Parser;

include_once './Controller/Basic_Controller.php';
include_once './Service/POD_service.php';
include_once './Libs/pdfparser-2.0.1/alt_autoload.php';

class POD_controller extends Basic_Controller
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
            if ($this->canUseAction("POD", "ADD")) {

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
                        $resultado = $this->add($fichero_subido);
                        $this->TodoOK($resultado);
                        unlink($fichero_subido);
                    } else {
                        $this->errorSubirArchivo("Error interno en la subida del archivo");
                    }
                } else {
                    $this->NoEncontrado("Se debe enviarun 'file' de tipo PDF (type=application/pdf y extension=.pdf)");
                }


            } else {
                $this->forbidden("POD", "ADD");
            }
        }
    }

    private function add($fichero_subido)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($fichero_subido);
        $pages = $pdf->getPages();
        $Pod_Service = new POD_service();

        return $Pod_Service->addPDF($pages);

    }

}