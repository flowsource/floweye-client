<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class PlanListFilter
{

	/** @var string[] */
	private $include = [];

	/** @var int|null */
	private $templateId;

	/**
	 * @return string[]
	 */
	public function getInclude(): array
	{
		return $this->include;
	}

	/**
	 * @param string[] $include
	 */
	public function setInclude(array $include): void
	{
		$this->include = $include;
	}

	public function getTemplateId(): ?int
	{
		return $this->templateId;
	}

	public function setTemplateId(?int $templateId): void
	{
		$this->templateId = $templateId;
	}

}
