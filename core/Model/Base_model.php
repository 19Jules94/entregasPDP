<?php
include_once './Model/Access_DB.php';

class Base_model {

    protected $db;

    function __construct() {
        $this->db = Connect();
    }

}

?>