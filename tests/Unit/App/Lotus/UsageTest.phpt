<?php declare(strict_types = 1);

namespace Tests\FlowEye\ApiClient\Unit\App\Lotus;

use FlowEye\ApiClient\App\Lotus\Client\ProcessClient;
use FlowEye\ApiClient\App\Lotus\Client\UserClient;
use FlowEye\ApiClient\App\Lotus\Requestor\ProcessRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\UserRequestor;
use FlowEye\ApiClient\Http\Guzzle\GuzzleClient;
use FlowEye\ApiClient\Http\Guzzle\GuzzleFactory;
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
