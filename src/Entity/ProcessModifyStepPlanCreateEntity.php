<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class ProcessModifyStepPlanCreateEntity extends AbstractBodyEntity
{

	public static function create(?string $from, ?string $to): self
	{
		$self = new self();
		$self->body['from'] = $from;
		$self->body['to'] = $to;

		return $self;
	}

	public function withModifyExpiration(bool $modify): self
	{
		$this->body['modify'] = $modify;

		return $this;
	}

}
