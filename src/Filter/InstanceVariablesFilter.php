<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

use Floweye\Client\Filter\Enum\InstanceVariableNumberOperator;
use Floweye\Client\Filter\Enum\InstanceVariableStringOperator;

class InstanceVariablesFilter
{

	/** @var array<string, mixed> */
	protected array $variables = [];

	public static function create(): static
	{
		return new static();
	}

	/**
	 * @return array<string, mixed>
	 */
	public function toVariables(): array
	{
		return $this->variables;
	}

	public function withNull(string $path, bool $isNull = true): static
	{
		$this->variables[($isNull ? '=' : '!=') . $path] = null;

		return $this;
	}

	public function withNumber(string $path, int|float $value, InstanceVariableNumberOperator $operator = InstanceVariableNumberOperator::equal): static
	{
		$this->variables[$operator->value . $path] = $value;

		return $this;
	}

	public function withString(string $path, string $value, InstanceVariableStringOperator $operator): static
	{
		$this->variables[$operator->value . $path] = $value;

		return $this;
	}

}
