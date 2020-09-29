<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

use DateTimeInterface;
use Nette\Utils\Json;

class ProcessListFilter extends BaseListFilter
{

	public const STATE_ACTIVE = 'active';
	public const STATE_COMPLETE = 'complete';

	public function withState(string $state): self
	{
		$this->parameters['state'] = $state;

		return $this;
	}

	public function withCreatorId(int $userId): self
	{
		$this->parameters['creatorId'] = $userId;

		return $this;
	}

	public function withPossibleResolverId(int $userId): self
	{
		$this->parameters['possibleResolverId'] = $userId;

		return $this;
	}

	public function withVariables(ProcessListVariablesFilter $variables): self
	{
		$this->parameters['variables'] = Json::encode($variables->toParameters());

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

	public function withResolverId(int $resolverId): self
	{
		$this->parameters['resolverId'] = $resolverId;

		return $this;
	}

	public function withTemplateId(int $templateId): self
	{
		$this->parameters['templateId'] = $templateId;

		return $this;
	}

	public function withPlannedFrom(DateTimeInterface $plannedFrom): self
	{
		$this->parameters['plannedFrom'] = $plannedFrom->format(DateTimeInterface::ATOM);

		return $this;
	}

	public function withPlannedTo(DateTimeInterface $plannedTo): self
	{
		$this->parameters['plannedTo'] = $plannedTo->format(DateTimeInterface::ATOM);

		return $this;
	}

}
