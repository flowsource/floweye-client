<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\App\Lotus;

use Floweye\Client\Client\TemplateProcessClient;
use Floweye\Client\Service\TemplateProcessService;
use Tests\Floweye\Client\Unit\App\AbstractAppTestCase;

class TemplateProcessServiceTest extends AbstractAppTestCase
{

	public function testListTemplates(): void
	{
		$service = $this->createService('templates.json');
		$res = $service->listTemplates();

		self::assertCount(4, $res);
	}

	public function testGetTemplate(): void
	{
		$service = $this->createService('template.json');
		$res = $service->getTemplate(2);

		self::assertEquals('Mereni casu ala toggle', $res['name']);
		self::assertEquals('Mereni casu ala toggle', $res['description']);
		self::assertEquals(3, $res['creator']);
		self::assertEquals(3, $res['steps']);
		self::assertEquals('2019-01-14T08:44:54+01:00', $res['created_at']);
	}

	public function testStartProcess(): void
	{
		$service = $this->createService('process.json');
		$res = $service->startProcess(1);

		self::assertEquals('Úkol', $res['name']);
	}

	private function createService(string $file): TemplateProcessService
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/data/' . $file));
		$client = new TemplateProcessClient($httpClient);

		return new TemplateProcessService($client);
	}

}
