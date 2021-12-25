<?php

namespace Ozone\Framework\Exceptions;


use Exception;

/**
 * PHP error exception.
 *
 */
class PHPErrorException extends Exception {

    public function __construct($code, $message, $file, $line, private $context = null) {
        parent::__construct($message, $code);
        $this->file = $file;
        $this->line = $line;
    }
}
