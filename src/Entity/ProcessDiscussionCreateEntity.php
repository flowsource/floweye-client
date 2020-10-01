<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

class ProcessDiscussionCreateEntity extends AbstractBodyEntity
{

	public const TYPE_NORMAL = 'normal';
	public const TYPE_SYSTEM = 'system';

	public static function create(string $comment): self
	{
		$self = new self();
		$self->body['comment'] = $comment;
		$self->body['notification'] = [];

		return $self;
	}

	public function withType(string $type): self
	{
		$this->body['type'] = $type;

		return $this;
	}

	public function withNotificationEnabled(bool $enabled): self
	{
		$this->body['notification']['enabled'] = $enabled;

		return $this;
	}

	public function withNotificationSubject(string $subject): self
	{
		$this->body['notification']['subject'] = $subject;

		return $this;
	}

}
