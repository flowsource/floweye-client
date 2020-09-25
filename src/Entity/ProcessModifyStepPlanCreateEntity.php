<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class ProcessModifyStepPlanCreateEntity
{

	/** @var string|null */
	private $from;

	/** @var string|null */
	private $to;

	/** @var bool */
	private $modifyExpiration;

	public function __construct(
		?string $from,
		?string $to,
		bool $modifyExpiration
	)
	{
		$this->from = $from;
		$this->to = $to;
		$this->modifyExpiration = $modifyExpiration;
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return [
			'from' => $this->from,
			'to' => $this->to,
			'modify' => $this->modifyExpiration,
		];
	}

}
