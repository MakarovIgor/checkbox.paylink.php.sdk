<?php

namespace igormakarov\PayLink\Models\Device\Property;

class TcpDeviceProperty implements IDeviceProperty
{
    private string $connectType = 'tcp';
    private string $mode = 'tcp';
    private int $port;
    private string $host;
    private string $merchantId;

    public function __construct(int $port, string $host, string $merchantId)
    {
        $this->port = $port;
        $this->host = $host;
        $this->merchantId = $merchantId;
    }

    public function toArray(): array
    {
        return [
            "connectType" => $this->connectType,
            "mode" => $this->mode,
            "port" => $this->port,
            "host" => $this->host,
            "merchant_id" => $this->merchantId
        ];
    }
}