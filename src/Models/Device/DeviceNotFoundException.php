<?php

namespace igormakarov\PayLink\Models\Device;

use Exception;
use Throwable;

class DeviceNotFoundException extends Exception
{
    public function __construct(
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}