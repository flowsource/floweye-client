<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

use DateTimeInterface;

class TimerEntryCreateEntity extends AbstractBodyEntity
{

	public static function create(string $timer, int $stepId): self
	{
		$self = new self();
		$self->body['timer'] = $timer;
		$self->body['stepId'] = $stepId;

		return $self;
	}

	public function withStart(DateTimeInterface $start): self
	{
		$this->body['start'] = $start->format(DateTimeInterface::RFC3339);

		return $this;
	}

	public function withEnd(DateTimeInterface $end): self
	{
		$this->body['end'] = $end->format(DateTimeInterface::RFC3339);

		return $this;
	}

	public function withResolver(int $resolver): self
	{
		$this->body['resolver'] = $resolver;

		return $this;
	}

	public function withUniqueTimer(bool $unique): self
	{
		$this->body['unique'] = $unique;

		return $this;
	}

}
