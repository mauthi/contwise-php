<?php

namespace Contwise;

use Contwise\Api\Connection;
use Contwise\Resources\Feature;
use Contwise\Resources\Medium;
use Contwise\Resources\Protocol;

class Contwise
{
    private $connection;
    private String $baseUrl = 'https://staging-tirol.mapservices.eu/nefos_app/';

    public function __construct($apiKey, $editApiKey, $debug = false)
    {
        $this->connection = new Connection(['apiKey' => $apiKey, 'editApiKey' => $editApiKey, 'apiUrl' => $this->baseUrl, 'debug' => $debug]);
    }

    public function getConnection() :Connection
    {
        return $this->connection;
    }

    public static function getObject() :self
    {
        return new self($_ENV['CONTWISE_API_KEY'], $_ENV['CONTWISE_EDIT_API_KEY']);
    }

    public static function getMediumResource() :Medium
    {
        return new Medium(self::getObject()->getConnection());
    }
    
    public static function getProtocolResource() :Protocol
    {
        return new Protocol(self::getObject()->getConnection());
    }

    public static function getFeaturesResource() :Feature
    {
        return new Feature(self::getObject()->getConnection());
    }
}
