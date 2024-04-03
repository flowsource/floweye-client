<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

final class Response
{

	private const STATUS_SUCCESS = 'success';

	private ?string $status = null;

	private ?string $message = null;

	private ?int $code = null;

	private mixed $data = null;

	/** @var mixed[]|null */
	private ?array $context = null;

	/**
	 * @param mixed[]|null  $context
	 */
	public function __construct(
		string $status,
		mixed $data = null,
		?int $code = null,
		?string $message = null,
		?array $context = null
	)
	{
		$this->status = $status;
		$this->data = $data;
		$this->code = $code;
		$this->message = $message;
		$this->context = $context;
	}

	public function getStatus(): ?string
	{
		return $this->status;
	}

	public function getMessage(): ?string
	{
		return $this->message;
	}

	public function getCode(): ?int
	{
		return $this->code;
	}

	public function getData(): mixed
	{
		return $this->data;
	}

	/**
	 * @return mixed[]|null
	 */
	public function getContext(): ?array
	{
		return $this->context;
	}

	public function isSuccess(): bool
	{
		return $this->status === self::STATUS_SUCCESS;
	}

}
