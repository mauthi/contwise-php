<?php

namespace Contwise\Resources;

use Contwise\Api\Connection;

/**
 * Class Protocol.
 *
 * @namespace    Contwise\Resources
 * @author     Mauthi <mauthi@gmail.com>
 */
class Protocol extends AbstractResource implements ResourceInterface
{
    public const RESOURCE_URL = 'web/api/trackmanagement/protocol/edit/';

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, self::RESOURCE_URL);
    }

    public function upload(array $data, int $memberGroupId): array
    {
        $url = self::RESOURCE_URL;

        $options['headers']['Member-Group-Id'] = $memberGroupId;

        $response = $this->jsonRequest($url, $data, $options);

        return $response;
    }
}
