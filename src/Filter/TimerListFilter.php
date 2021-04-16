<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class TimerListFilter extends AbstractListFilter
{

	public static function create(): self
	{
		return new self();
	}

	public function withResolver(?int $resolver): self
	{
		$this->parameters['resolver'] = $resolver;

		return $this;
	}

	public function withTitle(?string $title): self
	{
		$this->parameters['title'] = $title;

		return $this;
	}

	/**
	 * @param string[] $include
	 */
	public function withInclude(array $include): self
	{
		$this->parameters['include'] = implode(',', $include);

		return $this;
	}

}
