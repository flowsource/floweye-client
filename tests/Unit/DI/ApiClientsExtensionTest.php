<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\DI;

use Floweye\Client\Client\CalendarClient;
use Floweye\Client\Client\PlanClient;
use Floweye\Client\Client\ProcessClient;
use Floweye\Client\Client\SnippetClient;
use Floweye\Client\Client\UserClient;
use Floweye\Client\Client\UserGroupClient;
use Floweye\Client\DI\ApiClientsExtension;
use Floweye\Client\DI\ApiClientsExtension24;
use Floweye\Client\Http\Guzzle\GuzzleFactory;
use Floweye\Client\Http\HttpClient;
use Floweye\Client\Service\CalendarService;
use Floweye\Client\Service\PlanService;
use Floweye\Client\Service\ProcessService;
use Floweye\Client\Service\SnippetService;
use Floweye\Client\Service\UserGroupService;
use Floweye\Client\Service\UserService;
use Nette\DI\Compiler;
use Nette\DI\Definitions\ServiceDefinition;
use Tests\Floweye\Client\Toolkit\ContainerTestCase;

class ApiClientsExtensionTest extends ContainerTestCase
{

	protected function setUpCompileContainer(Compiler $compiler): void
	{
		parent::setUpCompileContainer($compiler);

		$extension = class_exists(ServiceDefinition::class)
			? new ApiClientsExtension()
			: new ApiClientsExtension24();
		$compiler->addExtension('ispa.apis', $extension);
		$compiler->addConfig([
			'ispa.apis' => [
				'http' => [
					'base_uri' => 'http://floweye.tld/api/v1',
					'headers' => [
						'X-Api-Token' => 'foobar',
					],
				],
			],
		]);
	}

	public function testServicesRegistration(): void
	{
		$container = $this->getContainer();

		// CorePass
		static::assertInstanceOf(GuzzleFactory::class, $container->getService('ispa.apis.guzzleFactory'));

		// AppLotusPass
		static::assertInstanceOf(HttpClient::class, $container->getService('ispa.apis.http.client'));

		static::assertInstanceOf(CalendarClient::class, $container->getService('ispa.apis.client.calendar'));
		static::assertInstanceOf(PlanClient::class, $container->getService('ispa.apis.client.plan'));
		static::assertInstanceOf(ProcessClient::class, $container->getService('ispa.apis.client.process'));
		static::assertInstanceOf(SnippetClient::class, $container->getService('ispa.apis.client.snippet'));
		static::assertInstanceOf(UserClient::class, $container->getService('ispa.apis.client.user'));
		static::assertInstanceOf(UserGroupClient::class, $container->getService('ispa.apis.client.userGroup'));

		static::assertInstanceOf(CalendarService::class, $container->getService('ispa.apis.requestor.calendar'));
		static::assertInstanceOf(PlanService::class, $container->getService('ispa.apis.requestor.plan'));
		static::assertInstanceOf(ProcessService::class, $container->getService('ispa.apis.requestor.process'));
		static::assertInstanceOf(SnippetService::class, $container->getService('ispa.apis.requestor.snippet'));
		static::assertInstanceOf(UserService::class, $container->getService('ispa.apis.requestor.user'));
		static::assertInstanceOf(UserGroupService::class, $container->getService('ispa.apis.requestor.userGroup'));
	}

}
