<?php

namespace igormakarov\PayLink;

class HostConfig
{
    private string $ipOrHost;
    private int $port;

    public function __construct(string $ipOrHost, int $port)
    {
        $this->ipOrHost = $ipOrHost;
        $this->port = $port;
    }

    public function getUrl(): string
    {
        return $this->ipOrHost . ":" . $this->port;
    }
}