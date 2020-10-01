<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class UserEditEntity extends AbstractBodyEntity
{

	public const STATES_NEW = 'new';
	public const STATES_BLOCKED = 'blocked';
	public const STATES_ACTIVATED = 'activated';

	public const ROLES_SUPERADMIN = 'superadmin';
	public const ROLES_ADMIN = 'admin';
	public const ROLES_SYSTEM = 'system';
	public const ROLES_USER = 'user';
	public const ROLES_GUEST = 'guest';

	public static function create(string $name, string $surname, string $email, string $username, string $role, string $state): self
	{
		$self = new self();
		$self->body['name'] = $name;
		$self->body['surname'] = $surname;
		$self->body['email'] = $email;
		$self->body['username'] = $username;
		$self->body['role'] = $role;
		$self->body['state'] = $state;

		return $self;
	}

}
