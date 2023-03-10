<?php

namespace Contwise\Enums;

class Priority extends AbstractEnum
{
    public static function getData(): array
    {
        return [
            'PRIORITY_NONE' => [
                'name' => 'Keine',
                'public' => false,
            ],
            'PRIORITY_LOW' => [
                'name' => 'Niedrig',
                'public' => true,
            ],
            'PRIORITY_MID' => [
                'name' => 'Mittel',
                'public' => true,
            ],
            'PRIORITY_HIGH' => [
                'name' => 'Hoch',
                'public' => true,
            ],
        ];
    }
}
