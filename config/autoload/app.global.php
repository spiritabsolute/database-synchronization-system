<?php
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
	"debug" => true,
	"dependencies" => [
		"abstract_factories" => [
			ReflectionBasedAbstractFactory::class
		],
		"factories" => []
	]
];