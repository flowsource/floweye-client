<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class InstanceCreateEntity extends AbstractBodyEntity
{

	public static function create(string $pid): self
	{
		$self = new self();
		$self->body['ident'] = $pid;
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
