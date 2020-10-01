<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class UserGroupCreateEntity extends AbstractBodyEntity
{

	public static function create(string $gid, string $name): self
	{
		$self = new self();
		$self->body['gid'] = $gid;
		$self->body['name'] = $name;

		return $self;
	}

}
