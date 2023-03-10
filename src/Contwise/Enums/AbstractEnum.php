<?php

namespace Contwise\Enums;

abstract class AbstractEnum
{
    abstract public static function getData(): array;

    public static function getPublicData(): array
    {
        $data = static::getData();
        $result = [];

        foreach ($data as $key => $value) {
            if (isset($value['public']) && $value['public']) {
                $result[] = [
                    'const' => $key,
                    'name' => $value['name'],
                ];
            }
        }

        return $result;
    }

    public static function getAllData(): array
    {
        $data = static::getData();
        $result = [];

        foreach ($data as $key => $value) {
            $result[] = [
                'const' => $key,
                'name' => $value['name'],
            ];
        }

        return $result;
    }

    public static function getKeys(): array
    {
        return array_keys(static::getData());
    }
}
