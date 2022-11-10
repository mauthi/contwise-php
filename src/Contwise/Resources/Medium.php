<?php

namespace Contwise\Resources;

use Contwise\Api\Connection;
use Contwise\Exceptions\ContwiseException;
use GuzzleHttp\Psr7\Utils;

/**
 * Class Medium.
 *
 * @namespace    Contwise\Resources
 * @author     Mauthi <mauthi@gmail.com>
 */
class Medium extends AbstractResource implements ResourceInterface
{
    const RESOURCE_URL = 'api/MediumEdit.action';

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, self::RESOURCE_URL);
    }

    public function upload(string $filePath, string $name) : array
    {
        $url = self::RESOURCE_URL;
        $data = [
            [
                'name' => 'name',
                'contents' => $name,
            ],
            [
                'name' => 'file',
                'contents' => Utils::tryFopen($filePath, 'r'),
            ],
        ];

        $options = [];
        // &mediumId=-1&locale=de&cloudSync=true
        $options['query'] = [
            'mediumId' => -1,
            'locale' => 'de',
            'cloudSync' => 'true',
            'apiKey' => $this->connection->getOption('apiKey'),
            'editApiKey' => $this->connection->getOption('editApiKey'),
        ];
        $options['headers']['Content-Type'] = 'multipart/form-data';

        $response = $this->postRequest($url, $data, $options);
        return [];
        // echo "<pre>";
        // print_r($response);
    }
}
