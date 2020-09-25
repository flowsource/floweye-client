<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

use DateTimeInterface;

class TimerEntryEditEntity
{

	/** @var int */
	private $resolver;

	/** @var DateTimeInterface */
	private $start;

	/** @var DateTimeInterface */
	private $end;

	/** @var string|null */
	private $note;

	public function __construct(int $resolver, DateTimeInterface $start, DateTimeInterface $end, ?string $note = null)
	{
		$this->resolver = $resolver;
		$this->start = $start;
		$this->end = $end;
		$this->note = $note;
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return [
			'resolver' => $this->resolver,
			'start' => $this->start->format(DateTimeInterface::RFC3339),
			'end' => $this->end->format(DateTimeInterface::RFC3339),
			'note' => $this->note,
		];
	}

}
