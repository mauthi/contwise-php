<?php

namespace Contwise\Enums;

class FeatureType extends AbstractEnum
{
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
