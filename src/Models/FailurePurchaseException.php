<?php

namespace igormakarov\PayLink\Models;

use Exception;

class FailurePurchaseException extends Exception
{
    private array $extraData;
    public function __construct(string $message, int $code, array $extraData = [])
    {
        parent::__construct($message, $code);
        $this->extraData = $extraData;
    }

    public function getExtraData(): array
    {
        return $this->extraData;
    }
}