<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Entity;

class UserGroupEditEntity
{

	/** @var int */
	private $id;

	/** @var string */
	private $gid;

	/** @var string */
	private $name;

	public function __construct(int $id, string $gid, string $name)
	{
		$this->id = $id;
		$this->gid = $gid;
		$this->name = $name;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getGid(): string
	{
		return $this->gid;
	}

	public function getName(): string
	{
		return $this->name;
	}

}
