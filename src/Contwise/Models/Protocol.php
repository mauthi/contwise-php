<?php

namespace Contwise\Models;

use Contwise\Resources\Protocol as ResourcesProtocol;

class Protocol extends AbstractModel
{
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public static function upload(array $data, int $memberGroupId, ResourcesProtocol $endpoint): self
    {
        $result = $endpoint->upload($data, $memberGroupId);

        return new self($result);
    }
}
