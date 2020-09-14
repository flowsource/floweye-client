<?php declare(strict_types = 1);

namespace Floweye\Client\Exception\Runtime;

use Floweye\Client\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface;

class ResponseException extends RuntimeException
{

	/** @var ResponseInterface */
	private $response;

	public function __construct(ResponseInterface $response, ?string $message = null)
	{
		if ($message === null) {
			$message = sprintf('Unexpected status code "%d".', $response->getStatusCode());
		}

		parent::__construct($message, $response->getStatusCode());

		$this->response = $response;
	}

	public function getResponse(): ResponseInterface
	{
		return $this->response;
	}

}
