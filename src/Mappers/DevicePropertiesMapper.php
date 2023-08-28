<?php

namespace igormakarov\PayLink\Mappers;

use Exception;
use igormakarov\PayLink\Models\Device\DeviceModeTypes;
use igormakarov\PayLink\Models\Device\Property\IDeviceProperty;
use igormakarov\PayLink\Models\Device\Property\RS232DeviceProperty;
use igormakarov\PayLink\Models\Device\Property\TcpDeviceProperty;

class DevicePropertiesMapper
{
    /**
     * @throws Exception
     */
    public static function newInstance(array $data): IDeviceProperty
    {
        if ($data['mode'] == DeviceModeTypes::TCP) {
            return new TcpDeviceProperty($data['port'], $data['host'], $data['merchant_id']);
        } else if ($data['mode'] == DeviceModeTypes::RS232) {
            return new RS232DeviceProperty($data['port'], $data['baudrate'], $data['merchant_id']);
        } else {
            throw new Exception("Undefined type");
        }
    }
}