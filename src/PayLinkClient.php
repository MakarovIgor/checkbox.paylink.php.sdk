<?php

namespace igormakarov\PayLink;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use igormakarov\PayLink\Mappers\DeviceMapper;
use igormakarov\PayLink\Mappers\PurchaseResultMapper;
use igormakarov\PayLink\Models\Device\Device;
use igormakarov\PayLink\Models\Device\DeviceNotFoundException;
use igormakarov\PayLink\Models\FailurePurchaseException;
use igormakarov\PayLink\Models\PurchaseResult;
use igormakarov\PayLink\Routes\Route;
use igormakarov\PayLink\Routes\Routes;
use Throwable;

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
     * @throws Throwable
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
     * @throws Throwable
     */
    public function registerDevice(Device $device): Device
    {
        return DeviceMapper::newInstance($this->sendRequest($this->routes->registerDevice($device)));
    }

    /**
     * @throws Throwable
     */
    public function getDevice($deviceId): Device
    {
        try {
            return DeviceMapper::newInstance(
                $this->sendRequest($this->routes->getDevice($deviceId))
            );
        } catch (Throwable $exception) {
            if ($exception->getCode() == 404) {
                throw new DeviceNotFoundException("Device not found");
            }
            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function saveDevices()
    {
        $this->sendRequest($this->routes->saveConfig());
    }

    /**
     * @throws FailurePurchaseException
     * @throws Throwable
     */
    public function purchase(string $deviceId, int $amount): PurchaseResult
    {
        $data = $this->sendRequest($this->routes->purchase($deviceId, $amount));
        if ($data['success']) {
            return PurchaseResultMapper::newInstance($data['result']);
        }
        throw new FailurePurchaseException($data['error'], $data['code'], $data['result'] ?? []);
    }

    /**
     * @throws Throwable
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
        } catch (ServerException $exception) {
            return json_decode($exception->getResponse()->getBody()->getContents(), true);
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $responseData;
    }

    protected function prepareRequestBody(Route $route): array
    {
        return array_merge($route->body(), ['timeout' => 120]);
    }

}