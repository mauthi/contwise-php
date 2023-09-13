<?php

namespace Contwise;

use Contwise\Api\Connection;
use Contwise\Resources\Feature;
use Contwise\Resources\Medium;
use Contwise\Resources\Protocol;

class Contwise
{
    private $connection;

    public function __construct($apiKey, $editApiKey, $baseUrl, $debug = false)
    {
        $this->connection = new Connection(['apiKey' => $apiKey, 'editApiKey' => $editApiKey, 'apiUrl' => $baseUrl, 'debug' => $debug]);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public static function getObject($apiKey, $editApiKey, $baseUrl): self
    {
        return new self($apiKey, $editApiKey, $baseUrl);
    }

    public static function getMediumResource($apiKey, $editApiKey, $baseUrl): Medium
    {
        return new Medium(self::getObject($apiKey, $editApiKey, $baseUrl)->getConnection());
    }

    public static function getProtocolResource($apiKey, $editApiKey, $baseUrl): Protocol
    {
        return new Protocol(self::getObject($apiKey, $editApiKey, $baseUrl)->getConnection());
    }

    public static function getFeaturesResource($apiKey, $editApiKey, $baseUrl): Feature
    {
        return new Feature(self::getObject($apiKey, $editApiKey, $baseUrl)->getConnection());
    }
}
