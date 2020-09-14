<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\Exception\Runtime;

use Floweye\Client\Exception\Runtime\ResponseException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ResponseExceptionTest extends TestCase
{

	public function testResponse(): void
	{
		$response = new Response();
		$e = new ResponseException($response);

		self::assertSame($response, $e->getResponse());
	}

}
