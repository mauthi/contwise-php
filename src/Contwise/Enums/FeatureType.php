<?php

namespace Contwise\Enums;

class FeatureType extends AbstractEnum
{
    const SERVICE_POSITION = 'ServicePosition';
    const SERVICE_PATH = 'ServicePath';

    public static function getData(): array
    {
        return [
            'ServicePosition' => [
                'name' => 'Wegweiser',
                'public' => false,
            ],
            'ServicePath' => [
                'name' => 'Weg',
                'public' => true,
            ],
        ];
    }
}
