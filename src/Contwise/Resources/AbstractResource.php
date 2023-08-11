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
    const PAGE_SIZE = 30;
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

    protected function filterResult(array $result, array $unset = []): array
    {
        $this->unsetValuesBySchema($result, $unset);

        // array_walk_recursive($result, function (&$value) {
        //     $value = htmlspecialchars_decode($value);
        // });

        if (isset($result['properties']['creationDate'])) {
            $result['properties']['creationDate'] = $this->transformDateTime($result['properties']['creationDate']);
        }

        if (isset($result['properties']['editDate'])) {
            $result['properties']['editDate'] = $this->transformDateTime($result['properties']['editDate']);
        }

        return $result;
    }

    private function transformDateTime(int $microseconds): \DateTime
    {
        $seconds = floor($microseconds / 1000); // ignore micro seconds

        $date = new \DateTime("@$seconds");
        $date->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        return $date;
    }

    public function unsetValuesBySchema(array &$target, array $unset): void
    {
        foreach ($unset as $key => $value) {
            if (is_numeric($key) && is_string($value)) {
                // Direkten Wert unsetten
                unset($target[$value]);
            } elseif (is_string($key) && is_array($value)) {
                // Wenn der Schlüssel im Ziel-Array existiert und es sich um ein Array handelt, tauchen wir rekursiv ein
                if (isset($target[$key]) && is_array($target[$key])) {
                    $this->unsetValuesBySchema($target[$key], $unset[$key]);
                }
            }
        }
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
