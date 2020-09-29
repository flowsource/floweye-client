<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class BaseListFilter extends AbstractListFilter
{

	final protected function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return static
	 */
	public static function create(int $limit = 10, int $offset = 0): self
	{
		$self = new static();

		$self->parameters['limit'] = $limit;
		$self->parameters['offset'] = $offset;

		return $self;
	}

}
