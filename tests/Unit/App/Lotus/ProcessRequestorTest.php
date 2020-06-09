<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\App\Lotus;

use Floweye\Client\App\Lotus\Client\ProcessClient;
use Floweye\Client\App\Lotus\Requestor\ProcessRequestor;
use Tests\Floweye\Client\Unit\App\AbstractAppTestCase;

class ProcessRequestorTest extends AbstractAppTestCase
{

	public function testListProcesses(): void
	{
		$requestor = $this->createRequestor('processes.json');
		$res = $requestor->listProcesses();

		self::assertCount(10, $res);
	}

	public function testGetProcess(): void
	{
		$requestor = $this->createRequestor('process.json');
		$res = $requestor->getProcess(1);

		self::assertEquals('Úkol', $res['name']);
		self::assertEquals(1, $res['template']['id']);
		self::assertEquals('Zadání úkolu', $res['current_step']['name']);
		self::assertCount(9, $res['steps']);
	}

	public function testListTemplates(): void
	{
		$requestor = $this->createRequestor('templates.json');
		$res = $requestor->listTemplates();

		self::assertCount(4, $res);
	}

	public function testGetTemplate(): void
	{
		$requestor = $this->createRequestor('template.json');
		$res = $requestor->getTemplate(2);

		self::assertEquals('Mereni casu ala toggle', $res['name']);
		self::assertEquals('Mereni casu ala toggle', $res['description']);
		self::assertEquals(3, $res['creator']);
		self::assertEquals(3, $res['steps']);
		self::assertEquals('2019-01-14T08:44:54+01:00', $res['created_at']);
	}

	public function testStartProcess(): void
	{
		$requestor = $this->createRequestor('process.json');
		$res = $requestor->startProcess(1);

		self::assertEquals('Úkol', $res['name']);
	}

	private function createRequestor(string $file): ProcessRequestor
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/data/' . $file));
		$client = new ProcessClient($httpClient);

		return new ProcessRequestor($client);
	}

}
