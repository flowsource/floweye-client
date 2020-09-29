<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

abstract class AbstractListFilter
{

	/** @var mixed[] */
	protected $parameters = [];

	protected function __construct()
	{
	}

	/**
	 * @return mixed[]
	 */
	public function toParameters(): array
	{
		return $this->parameters;
	}

}
