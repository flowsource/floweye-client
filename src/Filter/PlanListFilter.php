<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class PlanListFilter extends BaseListFilter
{

	/**
	 * @param mixed[] $include
	 */
	public function withInclude(array $include): self
	{
		$this->parameters['include'] = implode(',', $include);

		return $this;
	}

	public function withTemplateId(int $templateId): self
	{
		$this->parameters['templateId'] = $templateId;

		return $this;
	}

}
