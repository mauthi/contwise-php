<?php

namespace Contwise\Models;

use Contwise\Contwise;

class ServicePosition extends AbstractModel
{
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public static function getByNumber($number) :self
    {
        $endpoint = Contwise::getFeaturesResource();
        $result = $endpoint->getByNumber($number);

        return new self($result);
    }

    public function getName() :string
    {
        return $this->getProperty('fullName');
    }

    public function getFirstImageUrl(?string $default = null) :?string
    {
        $images = $this->getProperty('images');
        if (!isset($images[0])) {
            return $default;
        }

        return $images[0]['baseUrl'].$images[0]['file'];
    }
}
