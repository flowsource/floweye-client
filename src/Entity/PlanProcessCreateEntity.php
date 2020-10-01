<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class PlanProcessCreateEntity extends AbstractBodyEntity
{

	public const STATE_ACTIVE = 'active';
	public const STATE_PAUSED = 'paused';
	public const STATE_STOPPED = 'stopped';

	public static function create(string $name, string $cron, string $formula, string $state, int $templateId): self
	{
		$self = new self();
		$self->body['name'] = $name;
		$self->body['cron'] = $cron;
		$self->body['formula'] = $formula;
		$self->body['state'] = $state;
		$self->body['templateId'] = $templateId;

		return $self;
	}

}
