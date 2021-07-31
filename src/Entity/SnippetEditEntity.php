<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class SnippetEditEntity extends AbstractBodyEntity
{

	public static function create(string $snippet): self
	{
		$self = new self();
		$self->body['snippet'] = $snippet;

		return $self;
	}

}
