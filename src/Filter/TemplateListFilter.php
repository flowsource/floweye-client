<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class TemplateListFilter extends BaseListFilter
{

	public function setState(string $state): self
	{
		$this->parameters['state'] = $state;

		return $this;
	}

	/**
	 * @param string[] $include
	 */
	public function setInclude(array $include): self
	{
		$this->parameters['include'] = implode(',', $include);

		return $this;
	}

	public function setStartableOnly(bool $startableOnly): self
	{
		$this->parameters['startableOnly'] = $startableOnly;

		return $this;
	}

}
