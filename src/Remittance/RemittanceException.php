<?php

namespace Seasofthpyosithu\GmoPayment\Remittance;

use Exception;
use Throwable;

class RemittanceException extends Exception {
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message . ' Call from Class ' . __CLASS__ . ' Method ' . __FUNCTION__;
        parent::__construct($message, $code, $previous);
    }
}
