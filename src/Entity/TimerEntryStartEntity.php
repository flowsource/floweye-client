<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class TimerEntryStartEntity
{

	/** @var int|null */
	private $resolver;

	public function __construct(?int $resolver)
	{
		$this->resolver = $resolver;
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return [
			'resolver' => $this->resolver,
		];
	}

}
