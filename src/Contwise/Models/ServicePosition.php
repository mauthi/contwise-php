<?php

namespace Contwise\Models;

use Contwise\Contwise;
use Contwise\Exceptions\ContwiseException;

class ServicePosition extends AbstractModel
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->checkDataType();
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

    public function getProperty(String $key) :mixed
    {
        if (!isset($this->data['properties'][$key])) {
            throw new ContwiseException("Property with key '{$key}' not found.");
        }

        return $this->data['properties'][$key];
    }

    private function checkDataType()
    {
        $reflect = new \ReflectionClass($this);

        if ($reflect->getShortName() !== $this->getProperty('soType')) {
            throw new ContwiseException("Data soType '{$this->getProperty('soType')}' does not match type '{$reflect->getShortName()}'\nData:".print_r($this->data, true));
        }
    }
}
