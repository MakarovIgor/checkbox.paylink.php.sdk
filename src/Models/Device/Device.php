<?php

namespace igormakarov\PayLink\Models\Device;

use igormakarov\PayLink\Models\Device\Property\IDeviceProperty;

class Device
{
    private string $id;
    private string $name;
    private string $type;
    private string $model;
    private string $protocol;
    private IDeviceProperty $properties;
    private bool $connected;

    public function __construct(
        string $id,
        string $name,
        string $type,
        string $model,
        string $protocol,
        IDeviceProperty $property,
        bool $connected = false
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->model = $model;
        $this->protocol = $protocol;
        $this->properties = $property;
        $this->connected = $connected;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function model(): string
    {
        return $this->model;
    }

    public function protocol(): string
    {
        return $this->protocol;
    }

    public function properties(): IDeviceProperty
    {
        return $this->properties;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "type" => $this->type,
            "model" => $this->model,
            "protocol" => $this->protocol,
            "properties" => $this->properties()->toArray(),
            "connected" => $this->connected
        ];
    }
}
