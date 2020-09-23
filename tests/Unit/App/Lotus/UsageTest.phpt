<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\App\Lotus;

use Floweye\Client\Client\ProcessClient;
use Floweye\Client\Client\UserClient;
use Floweye\Client\Requestor\ProcessRequestor;
use Floweye\Client\Requestor\UserRequestor;
use Floweye\Client\Http\Guzzle\GuzzleClient;
use Floweye\Client\Http\Guzzle\GuzzleFactory;
use PHPUnit\Framework\TestCase;

final class UsageTest extends TestCase
{

	/** @var GuzzleClient */
	private $guzzle;

	public function setUp(): void
	{
		// Change base_uri and X-Api-Token values
		$config = [
			'app' => [
				'lotus' => [
					'http' => [
						'base_uri' => 'http://localhost:8000/api/v1/',
						'headers' => [
							'X-Api-Token' => 'TOKEN',
						],
					],
				],
			],
		];

		$this->guzzle = (new GuzzleFactory($config))->create('lotus');
	}

	public function testListUsers(): void
	{
		$client = new UserClient($this->guzzle);
		$requestor = new UserRequestor($client);

		$res = $requestor->list();
		self::assertGreaterThan(0, count($res));
	}

	public function testListProcesses(): void
	{
		$client = new ProcessClient($this->guzzle);
		$requestor = new ProcessRequestor($client);

		$res = $requestor->listProcesses();
		self::assertGreaterThan(0, count($res));
	}

	public function testListProcessesByVariables(): void
	{
		$client = new ProcessClient($this->guzzle);
		$requestor = new ProcessRequestor($client);

		$res = $requestor->listProcessesByVariables(['processes1' => 73]);
		self::assertGreaterThan(0, count($res));
	}

	public function testStartProcess(): void
	{
		$client = new ProcessClient($this->guzzle);
		$requestor = new ProcessRequestor($client);

		$res = $requestor->startProcess(1);
		self::assertEquals(1, $res['template']['id']);
	}

}
