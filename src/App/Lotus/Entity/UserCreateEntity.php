<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Entity;

class UserCreateEntity
{

	/** @var string */
	private $name;

	/** @var string */
	private $surname;

	/** @var string */
	private $emailAddress;

	/** @var string */
	private $password;

	public function __construct(string $name, string $surname, string $emailAddress, string $password)
	{
		$this->name = $name;
		$this->surname = $surname;
		$this->emailAddress = $emailAddress;
		$this->password = $password;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getSurname(): string
	{
		return $this->surname;
	}

	public function getEmailAddress(): string
	{
		return $this->emailAddress;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

}
