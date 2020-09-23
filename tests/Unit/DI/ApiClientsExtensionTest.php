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
use Floweye\Client\Requestor\CalendarRequestor;
use Floweye\Client\Requestor\PlanRequestor;
use Floweye\Client\Requestor\ProcessRequestor;
use Floweye\Client\Requestor\SnippetRequestor;
use Floweye\Client\Requestor\UserGroupRequestor;
use Floweye\Client\Requestor\UserRequestor;
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
			'ispa.apis' => [],
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

		static::assertInstanceOf(CalendarRequestor::class, $container->getService('ispa.apis.requestor.calendar'));
		static::assertInstanceOf(PlanRequestor::class, $container->getService('ispa.apis.requestor.plan'));
		static::assertInstanceOf(ProcessRequestor::class, $container->getService('ispa.apis.requestor.process'));
		static::assertInstanceOf(SnippetRequestor::class, $container->getService('ispa.apis.requestor.snippet'));
		static::assertInstanceOf(UserRequestor::class, $container->getService('ispa.apis.requestor.user'));
		static::assertInstanceOf(UserGroupRequestor::class, $container->getService('ispa.apis.requestor.userGroup'));
	}

}
