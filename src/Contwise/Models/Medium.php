<?php

namespace Contwise\Models;

use Contwise\Resources\Medium as ResourcesMedium;

class Medium extends AbstractModel
{
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public static function upload(string $filePath, string $name, ResourcesMedium $endpoint): self
    {
        $result = $endpoint->upload($filePath, $name);

        return new self($result);
    }
}
