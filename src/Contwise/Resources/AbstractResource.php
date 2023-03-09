<?php

namespace Contwise\Resources;

use Contwise\Api\Connection;
use Contwise\Exceptions\ContwiseResponseException;

/**
 * Class AbstractResource.
 *
 * @namespace    Contwise\Resources
 * @author     Mauthi <mauthi@gmail.com>
 */
abstract class AbstractResource
{
    const SUCCESS = 'success';
    protected Connection $connection;
    protected String $resourceUrl;

    /**
     * AbstractResource constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection, string $resourceUrl)
    {
        $this->connection = $connection;
        $this->resourceUrl = $resourceUrl;
    }

    protected function filterResult($result)
    {
        // array_walk_recursive($result, function (&$value) {
        //     $value = htmlspecialchars_decode($value);
        // });

        return $result;
    }

    protected function getResult(array $result, string $key): ?array
    {
        if (isset($result[$key])) {
            return $result[$key];
        }

        return null;
    }

    protected function multipartRequest(string $url, array $data, array $options = [])
    {
        $options['multipart'] = $data;

        return $this->postRequest($url, $options);
    }

    protected function jsonRequest(string $url, array $data, array $options = [])
    {
        $options['json'] = $data;
        $options['headers']['Content-Type'] = 'application/json';

        return $this->postRequest($url, $options);
    }

    private function postRequest(string $url, array $options = [])
    {
        return $this->request('POST', $url, $options);
    }

    private function request(string $method, string $url, array $options = []): array
    {
        return $this->connection->request($method, $url, $options);
    }

    private function getResultSize($response): ?int
    {
        if (isset($response['features'])) {
            return count($response['features']);
        }

        return null;
    }

    protected function checkIfExactOneResult($response)
    {
        if ($this->getResultSize($response) !== 1) {
            throw new ContwiseResponseException("0 or more than 1 results found\nResponse: ".print_r($response, true));
        }
    }
}
