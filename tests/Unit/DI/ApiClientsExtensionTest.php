<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\DI;

use Floweye\Client\Client\ApplicationClient;
use Floweye\Client\Client\PlanClient;
use Floweye\Client\Client\ProcessClient;
use Floweye\Client\Client\TemplateProcessClient;
use Floweye\Client\Client\TimerClient;
use Floweye\Client\Client\UserClient;
use Floweye\Client\Client\UserGroupClient;
use Floweye\Client\DI\ApiClientsExtension;
use Floweye\Client\DI\ApiClientsExtension24;
use Floweye\Client\Http\Guzzle\GuzzleFactory;
use Floweye\Client\Http\HttpClient;
use Floweye\Client\Service\ApplicationService;
use Floweye\Client\Service\PlanService;
use Floweye\Client\Service\ProcessService;
use Floweye\Client\Service\TemplateProcessService;
use Floweye\Client\Service\TimerService;
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

		static::assertInstanceOf(ApplicationClient::class, $container->getService('ispa.apis.client.application'));
		static::assertInstanceOf(TemplateProcessClient::class, $container->getService('ispa.apis.client.templateProcess'));
		static::assertInstanceOf(PlanClient::class, $container->getService('ispa.apis.client.plan'));
		static::assertInstanceOf(ProcessClient::class, $container->getService('ispa.apis.client.process'));
		static::assertInstanceOf(UserClient::class, $container->getService('ispa.apis.client.user'));
		static::assertInstanceOf(UserGroupClient::class, $container->getService('ispa.apis.client.userGroup'));
		static::assertInstanceOf(TimerClient::class, $container->getService('ispa.apis.client.timer'));

		static::assertInstanceOf(ApplicationService::class, $container->getService('ispa.apis.service.application'));
		static::assertInstanceOf(TemplateProcessService::class, $container->getService('ispa.apis.service.templateProcess'));
		static::assertInstanceOf(PlanService::class, $container->getService('ispa.apis.service.plan'));
		static::assertInstanceOf(ProcessService::class, $container->getService('ispa.apis.service.process'));
		static::assertInstanceOf(UserService::class, $container->getService('ispa.apis.service.user'));
		static::assertInstanceOf(UserGroupService::class, $container->getService('ispa.apis.service.userGroup'));
		static::assertInstanceOf(TimerService::class, $container->getService('ispa.apis.service.timer'));
	}

}
