<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\App;

use Floweye\Client\Http\HttpClient;
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

			private int $status;

			private string $body;

			/** @var mixed[] */
			private array $headers;

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
