<?php

class DBException extends Exception
{
    private $ERROR;

    public function __construct($ERROR)
    {
        $this->ERROR = $ERROR;
    }

    public function getERROR()
    {
        return $this->ERROR;
    }
    
} 