<?php

namespace Contwise\Enums;

class ProtocolType { 

	public static function getData() :array 
	{
	    return [
	    	'TYPE_OK' => [
	    		'name' => 'OK',
	    		'public' => false,
	    	],
	    	'TYPE_DAMAGED' => [
	    		'name' => 'Kaputt',
	    		'public' => true,
	    	],
	    	'TYPE_UNUSEABLE' => [
	    		'name' => 'Nicht benutzbar',
	    		'public' => true,
	    	],
	    	'TYPE_MISSING' => [
	    		'name' => 'Schild oder dgl. fehlt',
	    		'public' => true,
	    	],
	    	'TYPE_DANGER' => [
	    		'name' => 'Gefährlich',
	    		'public' => true,
	    	],
	    	'TYPE_UNKNOWN' => [
	    		'name' => 'Unbekannt',
	    		'public' => true,
	    	],
	    	'TYPE_NEW' => [
	    		'name' => 'New',
	    		'public' => false,
	    	],
	    	'TYPE_PLANNED_CLOSURE' => [
	    		'name' => 'Geplante Schließung',
	    		'public' => false,
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