<?php


namespace igormakarov\PayLink\Mappers;


use Exception;
use igormakarov\PayLink\Models\Device\Device;

class DeviceMapper
{
    /**
     * @throws Exception
     */
    public static function newInstance(array $deviceData): Device
    {
        return new Device(
            $deviceData['id'],
            $deviceData['name'],
            $deviceData['type'],
            $deviceData['model'],
            $deviceData['protocol'],
            DevicePropertiesMapper::newInstance($deviceData['properties']),
            $deviceData['connected']
        );
    }
}