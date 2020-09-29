<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class TimerListFilter extends AbstractListFilter
{

	final protected function __construct()
	{
		parent::__construct();
	}

	public static function create(): self
	{
		return new static();
	}

	public function withResolver(?int $resolver): self
	{
		$this->parameters['resolver'] = $resolver;

		return $this;
	}

	public function withTimer(?string $timer): self
	{
		$this->parameters['timer'] = $timer;

		return $this;
	}

}
