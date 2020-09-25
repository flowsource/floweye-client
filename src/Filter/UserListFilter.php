<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class UserListFilter
{

	public const STATE_NEW = 'new';
	public const STATE_BLOCKED = 'blocked';
	public const STATE_ACTIVATED = 'activated';

	/** @var string|null */
	private $state;

	/** @var string|null */
	private $email;

	/** @var int|null */
	private $id;

	/** @var string|null */
	private $username;

	/** @var string[] */
	private $include = [];

	/**
	 * @return static
	 */
	public function setState(string $state): self
	{
		$this->state = $state;

		return $this;
	}

	public function getState(): ?string
	{
		return $this->state;
	}

	/**
	 * @return static
	 */
	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * @return static
	 */
	public function setId(int $id): self
	{
		$this->id = $id;

		return $this;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return static
	 */
	public function setUsername(string $username): self
	{
		$this->username = $username;

		return $this;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	/**
	 * @return string[]
	 */
	public function getInclude(): array
	{
		return $this->include;
	}

	/**
	 * @param string[] $include
	 */
	public function setInclude(array $include): void
	{
		$this->include = $include;
	}

}
