<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class UserGroupEditEntity
{

	/** @var string */
	private $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return [
			'name' => $this->name,
		];
	}

}
