<?php

namespace Contwise;

use Contwise\Api\Connection;
use Contwise\Resources\FeaturesResource;

class Contwise
{
    private $connection;
    private String $baseUrl = 'https://tirol.mapservices.eu/nefos_app/web/api/';

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

    public static function getFeaturesResource() :FeaturesResource
    {
        return new FeaturesResource(self::getObject()->getConnection());
    }
}
