<?php declare(strict_types = 1);

namespace Tests\FlowEye\ApiClient\Unit\App\Lotus;

use FlowEye\ApiClient\App\Lotus\Client\UserClient;
use FlowEye\ApiClient\App\Lotus\Requestor\UserRequestor;
use FlowEye\ApiClient\Exception\Runtime\ResponseException;
use FlowEye\ApiClient\Http\HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\FlowEye\ApiClient\Unit\App\AbstractAppTestCase;

class UserRequestorTest extends AbstractAppTestCase
{

	public function testList(): void
	{
		$usersRequestor = $this->createRequestor('users.json');
		$res = $usersRequestor->list();

		self::assertCount(10, $res);

		self::assertEquals('first@ispalliance.cz', $res[0]['email']);
		self::assertEquals(1, $res[0]['id']);

		self::assertEquals('tenth@gmail.com', $res[9]['email']);
		self::assertEquals(10, $res[9]['id']);
	}

	public function testGetById(): void
	{
		$usersRequestor = $this->createRequestor('user.json');
		$res = $usersRequestor->getById(1);

		self::assertEquals('user@ispalliance.cz', $res['email']);
		self::assertEquals('Leopoldus Augustus Ispus', $res['fullname']);
	}

	public function testError(): void
	{
		$this->expectException(ResponseException::class);
		$this->expectExceptionMessage('API error. Status: error, Message: Client authentication failed');
		$usersRequestor = $this->createRequestor('error.json');
		$usersRequestor->getById(1);
	}

	public function testSudoDisabled(): void
	{
		/** @var HttpClient|MockObject $httpClient */
		$httpClient = $this->createMock(HttpClient::class);
		$httpClient->method('request')->willReturnCallback(function (string $method, string $url, array $opts): Response {
			self::assertArrayNotHasKey('headers', $opts);

			return new Response(200, [], '{"status": "success"}');
		});

		$client = new UserClient($httpClient);
		$requestor = new UserRequestor($client);

		self::assertFalse($requestor->isSudo());
		$requestor->getById(1);
	}

	public function testSudoEnabled(): void
	{
		/** @var HttpClient|MockObject $httpClient */
		$httpClient = $this->createMock(HttpClient::class);
		$httpClient->method('request')->willReturnCallback(function (string $method, string $url, array $opts): Response {
			self::assertArrayHasKey('headers', $opts);
			self::assertArrayHasKey('X-Sudo', $opts['headers']);
			self::assertEquals('email@ispa.cz', $opts['headers']['X-Sudo']);

			return new Response(200, [], '{"status": "success"}');
		});

		$client = new UserClient($httpClient);
		$requestor = new UserRequestor($client);

		self::assertFalse($requestor->isSudo());
		$requestor->enableSudo('email@ispa.cz');
		self::assertTrue($requestor->isSudo());

		$requestor->getById(1);
	}

	private function createRequestor(string $file): UserRequestor
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/data/' . $file));
		$usersClient = new UserClient($httpClient);

		return new UserRequestor($usersClient);
	}

}
