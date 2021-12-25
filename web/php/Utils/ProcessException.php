<?php

namespace Wikidot\Utils;

use Exception;

class ProcessException extends Exception
{

    public function __construct($message, protected $status = "not_ok")
    {
       // some code

       // make sure everything is assigned properly
        parent::__construct($message, 1);
    }

    public function getStatus()
    {
        return $this->status;
    }
}
