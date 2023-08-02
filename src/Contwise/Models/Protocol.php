<?php

namespace Contwise\Models;

use Contwise\Contwise;

class Protocol extends AbstractModel
{
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public static function upload(array $data, int $memberGroupId): self
    {
        $endpoint = Contwise::getProtocolResource();
        $result = $endpoint->upload($data, $memberGroupId);

        return new self($result);
    }
}
