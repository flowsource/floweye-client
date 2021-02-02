<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

use DateTimeInterface;

class TimerEntryEditEntity extends AbstractBodyEntity
{

	public static function create(int $resolver, DateTimeInterface $start, ?DateTimeInterface $end): self
	{
		$self = new self();
		$self->body['resolver'] = $resolver;
		$self->body['start'] = $start->format(DateTimeInterface::RFC3339);
		if ($end !== null) {
			$self->body['end'] = $end->format(DateTimeInterface::RFC3339);
		}

		return $self;
	}

	public function withNote(string $note): self
	{
		$this->body['note'] = $note;

		return $this;
	}

}
