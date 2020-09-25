<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class UserCreateEntity
{

	public const STATES = ['new', 'blocked', 'activated'];
	public const ROLES = ['superadmin', 'admin', 'system', 'user', 'guest'];

	/** @var string */
	private $name;

	/** @var string */
	private $surname;

	/** @var string */
	private $email;

	/** @var string */
	private $password;

	/** @var string */
	private $role;

	/** @var string */
	private $state;

	public function __construct(string $name, string $surname, string $email, string $password, string $role, string $state)
	{
		$this->name = $name;
		$this->surname = $surname;
		$this->email = $email;
		$this->password = $password;
		$this->role = $role;
		$this->state = $state;
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return [
			'name' => $this->name,
			'surname' => $this->surname,
			'email' => $this->email,
			'password' => $this->password,
			'role' => $this->role,
			'state' => $this->state,
		];
	}

}
