<?php declare(strict_types = 1);

namespace Floweye\Client\Entity;

final class Response
{

	private const STATUS_SUCCESS = 'success';

	/** @var string|null */
	private $status;

	/** @var string|null */
	private $message;

	/** @var int|null */
	private $code;

	/** @var mixed|null */
	private $data;

	/** @var mixed[]|null */
	private $context;

	/**
	 * @param mixed|null  $data
	 * @param mixed[]|null  $context
	 */
	public function __construct(
		string $status,
		$data = null,
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

	/**
	 * @return mixed|null
	 */
	public function getData()
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
