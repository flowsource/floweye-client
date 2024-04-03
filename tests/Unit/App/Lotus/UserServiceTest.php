<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\App\Lotus;

use Floweye\Client\Client\UserClient;
use Floweye\Client\Exception\Runtime\ResponseException;
use Floweye\Client\Filter\UserListFilter;
use Floweye\Client\Http\HttpClient;
use Floweye\Client\Service\UserService;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Floweye\Client\Unit\App\AbstractAppTestCase;

class UserServiceTest extends AbstractAppTestCase
{

	public function testList(): void
	{
		$service = $this->createRequestor('users.json');
		$res = $service->list(UserListFilter::create());

		self::assertCount(10, $res);

		self::assertEquals('first@ispalliance.cz', $res[0]['email']);
		self::assertEquals(1, $res[0]['id']);

		self::assertEquals('tenth@gmail.com', $res[9]['email']);
		self::assertEquals(10, $res[9]['id']);
	}

	public function testGetById(): void
	{
		$service = $this->createRequestor('user.json');
		$res = $service->getById(1, []);

		self::assertEquals('user@ispalliance.cz', $res['email']);
		self::assertEquals('Leopoldus Augustus Ispus', $res['fullname']);
	}

	public function testError(): void
	{
		$this->expectException(ResponseException::class);
		$this->expectExceptionMessage('API error. Status: error, Message: Client authentication failed');
		$service = $this->createRequestor('error.json');
		$service->getById(1, []);
	}

	private function createRequestor(string $file): UserService
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/data/' . $file));
		$usersClient = new UserClient($httpClient);

		return new UserService($usersClient);
	}

}
