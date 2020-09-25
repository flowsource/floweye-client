<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\App\Lotus;

use Floweye\Client\Client\ProcessClient;
use Floweye\Client\Service\ProcessService;
use Tests\Floweye\Client\Unit\App\AbstractAppTestCase;

class ProcessServiceTest extends AbstractAppTestCase
{

	public function testListProcesses(): void
	{
		$service = $this->createService('processes.json');
		$res = $service->listProcesses();

		self::assertCount(10, $res);
	}

	public function testGetProcess(): void
	{
		$service = $this->createService('process.json');
		$res = $service->getProcess(1);

		self::assertEquals('Úkol', $res['name']);
		self::assertEquals(1, $res['template']['id']);
		self::assertEquals('Zadání úkolu', $res['current_step']['name']);
		self::assertCount(9, $res['steps']);
	}

	private function createService(string $file): ProcessService
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/data/' . $file));
		$client = new ProcessClient($httpClient);

		return new ProcessService($client);
	}

}
