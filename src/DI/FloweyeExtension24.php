<?php declare(strict_types = 1);

namespace Floweye\Client\DI;

class FloweyeExtension24 extends FloweyeExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => false,
		'http' => [
			'http_errors' => false,
		],
	];

	/**
	 * @return mixed[]
	 */
	public function getConfig(): array
	{
		return $this->validateConfig($this->defaults, parent::getConfig());
	}

}
