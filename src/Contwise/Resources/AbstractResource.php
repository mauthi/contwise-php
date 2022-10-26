<?php

namespace Contwise\Resources;

use Contwise\Api\Connection;
use Contwise\Exceptions\ContwiseException;

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
    public function __construct(Connection $connection, String $resourceUrl)
    {
        $this->connection = $connection;
        $this->resourceUrl = $resourceUrl;
    }

    /**
     * @return array
     */
    // public function getAll($filter = [])
    // {
    //     $limit = self::FASTBILL_LIMIT;
    //     $offset = 0;
    //     $result = [];
    //     $service = $this->_service.'.get';
    //     $resource = $this->_resource;

    //     $loopCount = 0;
    //     do {
    //         $loopCount++;
    //         $limitOffsetResult = $this->getResultOrDefaultValue($this->getRequest($service, $limit, $offset, $filter), $resource, []);
    //         //echo "LoopCount {$loopCount}: Limit: $limit / Offset: $offset / Size: ".sizeof($limitOffsetResult);
    //         $result = array_merge($result, $limitOffsetResult);
    //         $offset += $limit;
    //     } while (count($limitOffsetResult) > 0 && count($limitOffsetResult) == $limit);

    //     return $this->filterResult($result);
    // }

    // /**
    //  * @return array
    //  */
    // public function getOne($id)
    // {
    //     $service = $this->_service.'.get';
    //     $resource = $this->_resource;
    //     $filter = [];
    //     $filter[$this->_resourceKey] = $id;

    //     $response = $this->getRequest($service, 1, 0, $filter);
    //     $result = $this->getResultOrDefaultValue($response, $resource, false);

    //     if (!isset($result[0])) {
    //         throw new FastbillException('Resource with '.$this->_resourceKey." = {$id} not found in Fastbill (Service: {$service})\nResponse: ".print_r($response, true));
    //     }

    //     if ($result[0][$this->_resourceKey] != $id) {
    //         throw new FastbillException("Fastbill returned resource with wrong id (Service: {$service})\nResponse: ".print_r($response, true));
    //     }

    //     return $this->filterResult($result[0]);
    // }

    protected function filterResult($result)
    {
        // array_walk_recursive($result, function (&$value) {
        //     $value = htmlspecialchars_decode($value);
        // });

        return $result;
    }

    // /**
    //  * @return array Array of created resource or false
    //  */
    // public function create(array $data)
    // {
    //     $service = $this->_service.'.create';
    //     $result = $this->postRequest($service, $data);

    //     if ($this->getResultOrDefaultValue($result, 'STATUS') == self::SUCCESS && $id = $this->getResultOrDefaultValue($result, $this->_resourceKey)) {
    //         return $this->getOne($id);
    //     }

    //     return false;
    // }

    // /**
    //  * @return array Array of updated resource or false
    //  */
    // public function update($id, array $data)
    // {
    //     $data[$this->_resourceKey] = $id;
    //     $service = $this->_service.'.update';
    //     $result = $this->postRequest($service, $data);

    //     if ($this->getResultOrDefaultValue($result, 'STATUS') == self::SUCCESS && $id = $this->getResultOrDefaultValue($result, $this->_resourceKey)) {
    //         return $this->getOne($id);
    //     }

    //     return false;
    // }

    // /**
    //  * @param array $data
    //  * @return string
    //  */
    // public function updateOrCreate($id, array $data)
    // {
    //     if (is_null($id)) {
    //         return $this->create($data);
    //     } else {
    //         return $this->update($id, $data);
    //     }
    // }

    protected function getResult(array $result, String $key) :?array
    {
        if (isset($result[$key])) {
            return $result[$key];
        }

        return null;
    }

    // protected function getRequest($service, $limit = self::FASTBILL_LIMIT, $offset = 0, $filter = [])
    // {
    //     $requestData = ['SERVICE' => $service, 'LIMIT' => $limit, 'OFFSET' => $offset, 'FILTER' => $filter];

    //     return $this->request($requestData);
    // }

    protected function postRequest(String $url, array $data)
    {
        return $this->request('POST', $url, $data);
    }

    protected function request(String $method, String $url, array $data) :array
    {
        $result = $this->connection->request($method, $url, $data);

        // echo '<pre>';
        // print_r($result);
        // die();
        // if (isset($result['RESPONSE']['ERRORS'])) {
        //     throw new FastbillException("Error in Fastbill Request\nRequest: ".print_r($requestData, true)."\nResult: ".print_r($result, true));
        // }

        return $result;
    }

    private function getResultSize($response) :?int
    {
        if (isset($response['properties']['totalSize'])) {
            return $response['properties']['totalSize'];
        }

        return null;
    }

    protected function checkIfExactOneResult($response)
    {
        if ($this->getResultSize($response) !== 1) {
            throw new ContwiseException("0 or more than 1 results found\nResponse: ".print_r($response, true));
        }
    }
}
