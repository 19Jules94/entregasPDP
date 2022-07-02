<?php
const DB_name = "sced";
const user = "toor";
const pass = "toor";
const host = "localhost";

function Connect(){
    $mysqli = new mysqli(host,user,pass,DB_name);
    $mysqli->set_charset("utf8");
    
    if($mysqli -> connect_errno){
        echo "Error al conectar a la base de datos" . $mysqli->connect_error;
        exit();
    }else{
        return $mysqli;
    }
}