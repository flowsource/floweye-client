<?php declare(strict_types = 1);

namespace Tests\FlowEye\ApiClient\Unit\App;

use FlowEye\ApiClient\Http\HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractAppTestCase extends TestCase
{

	/**
	 * @param mixed[] $headers
	 */
	protected function createTestClient(int $status, string $body, array $headers = []): HttpClient
	{
		return new class($status, $body, $headers) implements HttpClient
		{

			/** @var int */
			private $status;

			/** @var string */
			private $body;

			/** @var mixed[] */
			private $headers;

			/**
			 * @param mixed[] $headers
			 */
			public function __construct(int $status, string $body, array $headers)
			{
				$this->status = $status;
				$this->body = $body;
				$this->headers = $headers;
			}

			/**
			 * @param mixed[] $options
			 */
			public function request(string $method, string $uri, array $options = []): ResponseInterface
			{
				return new Response($this->status, $this->headers, $this->body);
			}

		};
	}

}
