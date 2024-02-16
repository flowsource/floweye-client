<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

abstract class AbstractListFilter
{

	/** @var array<mixed> */
	protected array $parameters;

	protected function __construct()
	{
		$this->parameters = [];
	}

	/**
	 * @return mixed[]
	 */
	public function toParameters(): array
	{
		return $this->parameters;
	}

}
