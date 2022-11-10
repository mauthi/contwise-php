<?php

namespace Contwise\Resources;

use Contwise\Api\Connection;
use Contwise\Exceptions\ContwiseException;

/**
 * Class Features.
 *
 * @namespace    Contwise\Resources
 * @author     Mauthi <mauthi@gmail.com>
 */
class Feature extends AbstractResource implements ResourceInterface
{
    const RESOURCE_URL = 'web/api/trackmanagement/serviceobject/search';
    const RESOURCE_KEY = 'features';

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, self::RESOURCE_URL);
    }

    public function getByNumber(String $number) :array
    {
        $url = self::RESOURCE_URL;
        $data = [
            'number' => $number,
        ];

        $response = $this->postRequest($url, $data);

        $this->checkIfExactOneResult($response);

        // print_r($response);
        $result = $this->getResult($response, self::RESOURCE_KEY, false);

        if (!isset($result[0])) {
            throw new ContwiseException("Feature with number = {$number} not found in Contwise\nResponse: ".print_r($response, true));
        }

        return $this->filterResult($result[0]);
    }
}
