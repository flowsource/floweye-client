<?php declare(strict_types = 1);

namespace Floweye\Client\App\Lotus\Filter;

class ProcessListFilter
{

	public const STATE_ACTIVE = 'active';
	public const STATE_COMPLETE = 'complete';

	/** @var string|null */
	private $state;

	/** @var int|null */
	private $creatorId;

	/** @var int|null */
	private $possibleResolverId;

	/** @var mixed[]|null */
	private $variables;

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
	public function setCreatorId(int $userId): self
	{
		$this->creatorId = $userId;

		return $this;
	}

	public function getCreatorId(): ?int
	{
		return $this->creatorId;
	}

	/**
	 * @return static
	 */
	public function setPossibleResolverId(int $userId): self
	{
		$this->possibleResolverId = $userId;

		return $this;
	}

	public function getPossibleResolverId(): ?int
	{
		return $this->possibleResolverId;
	}

	/**
	 * @param mixed[] $variables
	 * @return static
	 */
	public function setVariables(array $variables): self
	{
		$this->variables = $variables;

		return $this;
	}

	/**
	 * @return mixed[]|null
	 */
	public function getVariables(): ?array
	{
		return $this->variables;
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
