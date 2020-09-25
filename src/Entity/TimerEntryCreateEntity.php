<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

use DateTimeInterface;

class TimerEntryCreateEntity
{

	/** @var string */
	private $timer;

	/** @var int */
	private $stepId;

	/** @var bool */
	private $unique;

	/** @var int|null */
	private $resolver;

	/** @var DateTimeInterface|null */
	private $start;

	/** @var DateTimeInterface|null */
	private $end;

	public function __construct(string $timer, int $stepId, bool $unique, ?int $resolver = null, ?DateTimeInterface $start = null, ?DateTimeInterface $end = null)
	{
		$this->timer = $timer;
		$this->stepId = $stepId;
		$this->unique = $unique;
		$this->resolver = $resolver;
		$this->start = $start;
		$this->end = $end;
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return [
			'timer' => $this->timer,
			'stepId' => $this->stepId,
			'unique' => $this->unique,
			'resolver' => $this->resolver,
			'start' => $this->start === null ? null : $this->start->format(DateTimeInterface::RFC3339),
			'end' => $this->end === null ? null : $this->end->format(DateTimeInterface::RFC3339),
		];
	}

}
