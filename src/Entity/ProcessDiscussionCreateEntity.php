<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

final class ProcessDiscussionCreateEntity
{

	public const TYPE_NORMAL = 'normal';
	public const TYPE_SYSTEM = 'system';

	/** @var string */
	private $comment;

	/** @var string */
	private $type;

	/** @var string */
	private $notificationSubject;

	/** @var bool */
	private $notificationEnabled;

	public function __construct(
		string $comment,
		string $type,
		string $notificationSubject,
		bool $notificationEnabled
	)
	{
		$this->comment = $comment;
		$this->type = $type;
		$this->notificationSubject = $notificationSubject;
		$this->notificationEnabled = $notificationEnabled;
	}

	/**
	 * @return mixed[]
	 */
	public function toBody(): array
	{
		return [
			'comment' => $this->comment,
			'type' => $this->type,
			'notification' => [
				'subject' => $this->notificationSubject,
				'enabled' => $this->notificationEnabled,
			],
		];
	}

}
