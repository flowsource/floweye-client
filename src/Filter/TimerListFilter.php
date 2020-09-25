<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class TimerListFilter
{

	/** @var int|null */
	private $resolver;

	/** @var string|null */
	private $timer;

	public function getResolver(): ?int
	{
		return $this->resolver;
	}

	public function setResolver(?int $resolver): void
	{
		$this->resolver = $resolver;
	}

	public function getTimer(): ?string
	{
		return $this->timer;
	}

	public function setTimer(?string $timer): void
	{
		$this->timer = $timer;
	}

}
