<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

abstract class AbstractBodyEntity
{

	/** @var mixed[] */
	protected array $body = [];

	protected function __construct()
	{
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return $this->body;
	}

}
