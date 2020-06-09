<?php declare(strict_types = 1);

namespace Floweye\Client\App\Lotus\Entity;

class UserEditEntity
{

	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/** @var string */
	private $surname;

	/** @var string */
	private $userName;

	/** @var string */
	private $emailAddress;

	public function __construct(int $id, string $name, string $surname, string $emailAddress, string $username)
	{
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
		$this->emailAddress = $emailAddress;
		$this->userName = $username;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getSurname(): string
	{
		return $this->surname;
	}

	public function getUserName(): string
	{
		return $this->userName;
	}

	public function getEmailAddress(): string
	{
		return $this->emailAddress;
	}

}
