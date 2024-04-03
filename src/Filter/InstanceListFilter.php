<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

use Floweye\Client\Filter\Enum\InstanceCriterionOperator;
use Floweye\Client\Filter\Enum\InstanceSort;

class InstanceListFilter extends BaseListFilter
{

	/** @var array<mixed> */
	protected array $criteria = [];

	protected ?InstanceSort $sortColumn = null;

	protected bool $sortDirection = true;

	protected ?InstanceVariablesFilter $variablesFilter = null;

	/**
	 * @return array<string, mixed>
	 */
	public function toBody(): array
	{
		$criteria = $this->criteria;

		if ($this->variablesFilter !== null) {
			$criteria[] = [
				'key' => 'variables',
				'operator' => InstanceCriterionOperator::equal,
				'value' => $this->variablesFilter->toVariables(),
			];
		}

		$result = [
			'criteria' => $criteria,
			'dir' => $this->sortDirection ? 'asc' : 'desc',
		];

		if ($this->sortColumn !== null) {
			$result['sort'] = $this->sortColumn->value;
		}

		return array_merge($result, $this->parameters);
	}

	/**
	 * @param array<int> $ids
	 */
	public function withIds(array $ids, InstanceCriterionOperator $operator = InstanceCriterionOperator::equal): static
	{
		$this->setCriterion('id', $operator->value, $ids);

		return $this;
	}

	/**
	 * @param array<int> $ids
	 */
	public function withResolvers(array $ids, InstanceCriterionOperator $operator = InstanceCriterionOperator::equal): static
	{
		$this->setCriterion('resolver', $operator->value, $ids);

		return $this;
	}

	/**
	 * @param array<int> $ids
	 */
	public function withPossibleResolvers(array $ids, InstanceCriterionOperator $operator = InstanceCriterionOperator::equal): static
	{
		$this->setCriterion('possibleResolver', $operator->value, $ids);

		return $this;
	}

	/**
	 * @param array<int> $ids
	 */
	public function withReaders(array $ids, InstanceCriterionOperator $operator = InstanceCriterionOperator::equal): static
	{
		$this->setCriterion('reader', $operator->value, $ids);

		return $this;
	}

	/**
	 * @param array<int> $ids
	 */
	public function withCreator(array $ids, InstanceCriterionOperator $operator = InstanceCriterionOperator::equal): static
	{
		$this->setCriterion('creator', $operator->value, $ids);

		return $this;
	}

	/**
	 * @param array<int> $ids
	 */
	public function withTag(array $ids, InstanceCriterionOperator $operator = InstanceCriterionOperator::equal): static
	{
		$this->setCriterion('tag', $operator->value, $ids);

		return $this;
	}

	/**
	 * @param array<string> $idents
	 */
	public function withProcess(array $idents, InstanceCriterionOperator $operator = InstanceCriterionOperator::equal): static
	{
		$this->setCriterion('creator', $operator->value, $idents);

		return $this;
	}

	public function withFile(bool $hasFiles = true): static
	{
		$this->setCriterion('hasfiles', InstanceCriterionOperator::equal->value, $hasFiles ? ['yes'] : ['no']);

		return $this;
	}

	public function withExpired(bool $isExpired = true): static
	{
		$this->setCriterion('expired', InstanceCriterionOperator::equal->value, $isExpired ? ['yes'] : ['no']);

		return $this;
	}

	public function withVariables(InstanceVariablesFilter $filter): static
	{
		$this->variablesFilter = $filter;

		return $this;
	}

	/**
	 * @param bool $direction true = ASC, false = DESC
	 */
	public function withSort(InstanceSort $sort, bool $direction = true): static
	{
		$this->sortColumn = $sort;
		$this->sortDirection = $direction;

		return $this;
	}

	/**
	 * @param array<mixed> $value
	 */
	protected function setCriterion(string $key, string $operator, array $value): void
	{
		$this->criteria = array_filter($this->criteria, static fn ($criterion): bool => $criterion['key'] !== $key);

		$this->criteria[] = [
			'key' => $key,
			'operator' => $operator,
			'value' => $value,
		];
	}

}
