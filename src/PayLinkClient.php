<?php

namespace igormakarov\PayLink;

use Exception;
use GuzzleHttp\Client;
use igormakarov\PayLink\Mappers\DeviceMapper;
use igormakarov\PayLink\Mappers\PurchaseResultMapper;
use igormakarov\PayLink\Models\Device\Device;
use igormakarov\PayLink\Models\FailurePurchaseException;
use igormakarov\PayLink\Models\PurchaseResult;
use igormakarov\PayLink\Routes\Route;
use igormakarov\PayLink\Routes\Routes;

class PayLinkClient
{
    private Client $httpClient;
    private Routes $routes;

    public function __construct(HostConfig $hostConfig)
    {
        $this->httpClient = new Client(['headers' => ['Content-Type' => 'application/json',]]);
        $this->routes = new Routes($hostConfig);
    }

    /**
     * @throws Exception
     */
    public function getDevices(): array
    {
        $responseDevices = $this->sendRequest($this->routes->devices());

        return array_map(
            function ($data) {
                return DeviceMapper::newInstance($data);
            },
            $responseDevices
        );
    }

    /**
     * @throws Exception
     */
    public function registerDevice(Device $device): Device
    {
        return DeviceMapper::newInstance($this->sendRequest($this->routes->registerDevice($device)));
    }

    /**
     * @throws Exception
     */
    public function getDevice($deviceId): Device
    {
        return DeviceMapper::newInstance($this->sendRequest($this->routes->getDevice($deviceId)));
    }

    /**
     * @throws Exception
     */
    public function saveDevices()
    {
        $this->sendRequest($this->routes->saveConfig());
    }

    /**
     * @throws FailurePurchaseException
     * @throws Exception
     */
    public function purchase(string $deviceId, int $amount): PurchaseResult
    {
        $data = $this->sendRequest($this->routes->purchase($deviceId, $amount));
        if ($data['success']) {
            return PurchaseResultMapper::newInstance($data);
        }
        throw new FailurePurchaseException($data['error'], $data['code'], $data['result']);
    }

    /**
     * @throws Exception
     */
    protected function sendRequest(Route $route): array
    {
        try {
            $response = $this->httpClient->request($route->method(), $route->url(), $this->prepareRequestBody($route));

            $content = $response->getBody()->getContents();

            $responseData = json_decode($content, true);
            if (is_string($responseData)) { //при реєстрації пристрою чомусь json обгорнутий два рази (строка в строці)
                return json_decode($responseData, true);
            }
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }

        return $responseData;
    }

    protected function prepareRequestBody(Route $route): array
    {
        return array_merge($route->body(), ['timeout' => 120]);
    }

}