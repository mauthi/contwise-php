<?php

namespace Contwise\Resources;

use Contwise\Api\Connection;
use Contwise\Exceptions\ContwiseException;

/**
 * Class Protocol.
 *
 * @namespace    Contwise\Resources
 * @author     Mauthi <mauthi@gmail.com>
 */
class Protocol extends AbstractResource implements ResourceInterface
{
    const RESOURCE_URL = 'web/api/trackmanagement/protocol/edit/';

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, self::RESOURCE_URL);
    }

    public function upload(array $data) :array
    {
        $url = self::RESOURCE_URL;

        $response = $this->postRequest($url, $data);      
        return $response;
    }
}
