<?php

namespace Contwise\Models;

use Contwise\Exceptions\ContwiseException;

abstract class AbstractModel
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        
    }

    public function getId() :int
    {
        return $this->data['id'];
    }

    public function getData() :array
    {
        return $data;
    }


}
