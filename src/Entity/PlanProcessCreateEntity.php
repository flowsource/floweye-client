<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class PlanProcessCreateEntity
{

	public const STATE_ACTIVE = 'active';
	public const STATE_PAUSED = 'paused';
	public const STATE_STOPPED = 'stopped';

	/** @var string */
	private $name;

	/** @var string */
	private $cron;

	/** @var string */
	private $formula;

	/** @var string */
	private $state;

	/** @var int */
	private $templateId;

	public function __construct(
		string $name,
		string $cron,
		string $formula,
		string $state,
		int $templateId
	)
	{
		$this->name = $name;
		$this->cron = $cron;
		$this->formula = $formula;
		$this->state = $state;
		$this->templateId = $templateId;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getCron(): string
	{
		return $this->cron;
	}

	public function getFormula(): string
	{
		return $this->formula;
	}

	public function getState(): string
	{
		return $this->state;
	}

	public function getTemplateId(): int
	{
		return $this->templateId;
	}

}
