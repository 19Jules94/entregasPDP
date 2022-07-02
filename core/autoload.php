<?php
function controllers_autoload($classname){
	include 'Controller/' . $classname . '.php';
}

spl_autoload_register('controllers_autoload');