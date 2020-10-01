<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class UserGroupEditEntity extends AbstractBodyEntity
{

	public static function create(string $name): self
	{
		$self = new self();
		$self->body['name'] = $name;

		return $self;
	}

}
