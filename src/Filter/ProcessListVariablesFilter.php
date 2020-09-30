<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class ProcessListVariablesFilter extends AbstractListFilter
{

	public const OPERATORS_EQ = '=';
	public const OPERATORS_NEQ = '!=';
	public const OPERATORS_LIKE = '~';
	public const OPERATORS_NLIKE = '!~';
	public const OPERATORS_L = '<';
	public const OPERATORS_G = '>';

	public const CAST_JSON = 'json';
	public const CAST_NUMBER = 'number';

	public static function create(): self
	{
		return new self();
	}

	/**
	 * @param mixed $name
	 * @param mixed $value
	 */
	public function add($name, $value, ?string $operator = null, ?string $cast = null): self
	{
		$var = ['name' => $name, 'value' => $value];

		if ($operator !== null) {
			$var['operator'] = $operator;
		}

		if ($cast !== null) {
			$var['cast'] = $cast;
		}

		$this->parameters[] = $var;

		return $this;
	}

}
