<?php

namespace Contwise\Models;

use Contwise\Contwise;

class Medium extends AbstractModel
{
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public static function upload(string $filePath, string $name) :self
    {
        $endpoint = Contwise::getMediumResource();
        $result = $endpoint->upload($filePath, $name);

        return new self($result);
    }
}
