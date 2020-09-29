<?php declare(strict_types = 1);

namespace Floweye\Client\Filter;

class UserListFilter extends BaseListFilter
{

	public const STATE_NEW = 'new';
	public const STATE_BLOCKED = 'blocked';
	public const STATE_ACTIVATED = 'activated';

	public function withState(string $state): self
	{
		$this->parameters['state'] = $state;

		return $this;
	}

	public function withEmail(string $email): self
	{
		$this->parameters['email'] = $email;

		return $this;
	}

	public function withId(int $id): self
	{
		$this->parameters['id'] = $id;

		return $this;
	}

	public function withUsername(string $username): self
	{
		$this->parameters['username'] = $username;

		return $this;
	}

	/**
	 * @param mixed[] $include
	 */
	public function withInclude(array $include): self
	{
		$this->parameters['include'] = implode(',', $include);

		return $this;
	}

}
