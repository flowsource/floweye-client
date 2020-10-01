<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class UserCreateEntity extends AbstractBodyEntity
{

	public const STATES_NEW = 'new';
	public const STATES_BLOCKED = 'blocked';
	public const STATES_ACTIVATED = 'activated';

	public const ROLES_SUPERADMIN = 'superadmin';
	public const ROLES_ADMIN = 'admin';
	public const ROLES_SYSTEM = 'system';
	public const ROLES_USER = 'user';
	public const ROLES_GUEST = 'guest';

	public static function create(string $name, string $surname, string $email, string $password): self
	{
		$self = new self();
		$self->body['name'] = $name;
		$self->body['surname'] = $surname;
		$self->body['email'] = $email;
		$self->body['password'] = $password;

		return $self;
	}

	public function withRole(string $role): self
	{
		$this->body['role'] = $role;

		return $this;
	}

	public function withState(string $state): self
	{
		$this->body['state'] = $state;

		return $this;
	}

}
