<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class SnippetCreateEntity extends AbstractBodyEntity
{

	public static function create(string $name, string $description, string $snippet): self
	{
		$self = new self();
		$self->body['name'] = $name;
		$self->body['description'] = $description;
		$self->body['snippet'] = $snippet;

		return $self;
	}

}
