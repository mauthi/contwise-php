<?php

namespace Contwise\Models;

use Contwise\Exceptions\ContwiseException;

abstract class AbstractModel
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->checkDataType();
    }

    public function getId() :int
    {
        return $this->data['id'];
    }

    public function getData() :array
    {
        return $data;
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
