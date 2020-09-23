<?php declare(strict_types = 1);

namespace Floweye\Client\DI;

class ApiClientsExtension24 extends ApiClientsExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => false,
		'http' => [
			'http_errors' => false,
		],
	];

	/**
	 * @return mixed
	 */
	public function getConfig()
	{
		return $this->validateConfig($this->defaults, parent::getConfig());
	}

}
