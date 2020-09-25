<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class TemplateListFilter
{

	/** @var string|null */
	private $state;

	/** @var bool|null */
	private $startableOnly;

	/** @var string[] */
	private $include = [];

	/**
	 * @return static
	 */
	public function setState(string $state): self
	{
		$this->state = $state;

		return $this;
	}

	public function getState(): ?string
	{
		return $this->state;
	}

	/**
	 * @return string[]
	 */
	public function getInclude(): array
	{
		return $this->include;
	}

	/**
	 * @param string[] $include
	 */
	public function setInclude(array $include): void
	{
		$this->include = $include;
	}

	public function getStartableOnly(): ?bool
	{
		return $this->startableOnly;
	}

	public function setStartableOnly(?bool $startableOnly): void
	{
		$this->startableOnly = $startableOnly;
	}

}
