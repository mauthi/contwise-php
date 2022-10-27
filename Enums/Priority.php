<?php

namespace Contwise\Enums;

class Priority { 

	public static function getData() :array 
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

	public static function getPublicData() :array 
	{
		$data = self::getData();
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
}