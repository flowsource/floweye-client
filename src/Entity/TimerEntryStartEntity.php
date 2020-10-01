<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class TimerEntryStartEntity extends AbstractBodyEntity
{

	public static function create(): self
	{
		return new self();
	}

	public function withResolver(int $resolver): self
	{
		$this->body['resolver'] = $resolver;

		return $this;
	}

}
