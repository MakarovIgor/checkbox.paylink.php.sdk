<?php

namespace igormakarov\PayLink\Models\Device\Property;

class RS232DeviceProperty implements IDeviceProperty
{
    private string $connectType = 'rs232';
    private string $mode = 'rs232';
    private int $port;
    private int $baudrate;
    private string $merchantId;

    public function __construct(int $port, int $baudrate, string $merchantId)
    {
        $this->port = $port;
        $this->baudrate = $baudrate;
        $this->merchantId = $merchantId;
    }

    public function toArray(): array
    {
        return [
            "connectType" => $this->connectType,
            "mode" => $this->mode,
            "port" => $this->port,
            "baudrate" => $this->baudrate,
            "merchant_id" => $this->merchantId
        ];
    }
}