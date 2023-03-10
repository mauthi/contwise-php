<?php

namespace Contwise\Enums;

class ProtocolType  extends AbstractEnum
{
    public static function getData(): array
    {
        return [
            'TYPE_OK' => [
                'name' => 'OK (Intakt)',
                'public' => false,
            ],
            'TYPE_DAMAGED' => [
                'name' => 'Leicht beschädigt',
                'public' => true,
            ],
            'TYPE_UNUSEABLE' => [
                'name' => 'Schwer beschädigt',
                'public' => true,
            ],
            'TYPE_MISSING' => [
                'name' => 'Schild oder dgl. fehlt',
                'public' => true,
            ],
            'TYPE_DANGER' => [
                'name' => 'Gefahr in Verzug',
                'public' => true,
            ],
            'TYPE_UNKNOWN' => [
                'name' => 'Sonstiges',
                'public' => true,
            ],
            'TYPE_NEW' => [
                'name' => 'Neues Objekt',
                'public' => false,
            ],
            'TYPE_PLANNED_CLOSURE' => [
                'name' => 'Geplante Sperre',
                'public' => false,
            ],
        ];
    }
}
