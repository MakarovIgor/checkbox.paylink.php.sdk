<?php

namespace igormakarov\PayLink\Routes;

use igormakarov\PayLink\HostConfig;
use igormakarov\PayLink\Models\Device\Device;

class Routes
{
    private string $url;

    public function __construct(HostConfig $hostConfig)
    {
        $this->url = $hostConfig->getUrl() . '/api/';
    }

    public function devices(): Route
    {
        return new Route($this->url . 'devices/');
    }

    public function getDevice(string $deviceId): Route
    {
        return new Route($this->url . 'devices/' . $deviceId);
    }

    public function registerDevice(Device $device): Route
    {
        $deviceData = $device->toArray();
        unset($deviceData['id']);
        unset($deviceData['protocol']);
        unset($deviceData['model']);

        return new Route($this->url . 'devices/register', "POST", ['body' => json_encode($deviceData)]);
    }

    public function saveConfig(): Route
    {
        return new Route($this->url . 'pos/saveconfig', "POST");
    }

    public function purchase(string $deviceId, int $amount): Route
    {
        $body = ['body' => json_encode(['amount' => $amount])];
        return new Route($this->url . "pos/{$deviceId}/purchase", "POST", $body);
    }

    public function connect(string $deviceId): Route
    {
        return new Route($this->url . "device/connect/{$deviceId}", "POST");
    }

    public function disconnect(string $deviceId): Route
    {
        return new Route($this->url . "device/{$deviceId}", "DELETE");
    }
}