<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class InstanceDispatchEntity extends AbstractBodyEntity
{

	public static function create(): self
	{
		$self = new self();
		$self->body['events'] = [];

		return $self;
	}

	/**
	 * @param array<mixed> $data
	 */
	public function withEvent(string $name, array $data): self
	{
		$this->body['events'][] = [
			'event' => $name,
			'data' => $data,
		];

		return $this;
	}

}
