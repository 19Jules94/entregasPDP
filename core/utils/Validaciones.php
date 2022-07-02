<?php

function validarDNI($DNI)
{
    $letra = strtoupper(substr($DNI, -1));
    $numeros = substr($DNI, 0, -1);

    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
        return true;
    } else {
        return false;
    }
}

function validarPass($password)
{
    $len =  strlen($password);

    if ($len >= 4 && $len <= 30) {
        return true;
    } else {
        return false;
    }
}

function validarEmail($email)
{
    return (false !== filter_var($email, FILTER_VALIDATE_EMAIL));
}

function validarNombreAccion($nombreAccion)
{
    return preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]{3,20}$/", $nombreAccion);
}
function validarDescripcionAccion($descripcionAccion)
{
    return preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]{3,300}$/", $descripcionAccion);
}
function validarID($id)
{
    return preg_match("/^[0-9]+$/", $id);
}
