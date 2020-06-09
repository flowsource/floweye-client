<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Unit\DI;

use Floweye\Client\App\Lotus\Client\CalendarClient;
use Floweye\Client\App\Lotus\Client\PlanClient;
use Floweye\Client\App\Lotus\Client\ProcessClient;
use Floweye\Client\App\Lotus\Client\SnippetClient;
use Floweye\Client\App\Lotus\Client\UserClient;
use Floweye\Client\App\Lotus\Client\UserGroupClient;
use Floweye\Client\App\Lotus\LotusRootquestor;
use Floweye\Client\App\Lotus\Requestor\CalendarRequestor;
use Floweye\Client\App\Lotus\Requestor\PlanRequestor;
use Floweye\Client\App\Lotus\Requestor\ProcessRequestor;
use Floweye\Client\App\Lotus\Requestor\SnippetRequestor;
use Floweye\Client\App\Lotus\Requestor\UserGroupRequestor;
use Floweye\Client\App\Lotus\Requestor\UserRequestor;
use Floweye\Client\DI\ApiClientsExtension;
use Floweye\Client\DI\ApiClientsExtension24;
use Floweye\Client\Http\Guzzle\GuzzleFactory;
use Floweye\Client\Http\HttpClient;
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
				'app' => [
					'lotus' => [],
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
		static::assertInstanceOf(HttpClient::class, $container->getService('ispa.apis.app.lotus.http.client'));

		static::assertInstanceOf(CalendarClient::class, $container->getService('ispa.apis.app.lotus.client.calendar'));
		static::assertInstanceOf(PlanClient::class, $container->getService('ispa.apis.app.lotus.client.plan'));
		static::assertInstanceOf(ProcessClient::class, $container->getService('ispa.apis.app.lotus.client.process'));
		static::assertInstanceOf(SnippetClient::class, $container->getService('ispa.apis.app.lotus.client.snippet'));
		static::assertInstanceOf(UserClient::class, $container->getService('ispa.apis.app.lotus.client.user'));
		static::assertInstanceOf(UserGroupClient::class, $container->getService('ispa.apis.app.lotus.client.userGroup'));

		static::assertInstanceOf(CalendarRequestor::class, $container->getService('ispa.apis.app.lotus.requestor.calendar'));
		static::assertInstanceOf(PlanRequestor::class, $container->getService('ispa.apis.app.lotus.requestor.plan'));
		static::assertInstanceOf(ProcessRequestor::class, $container->getService('ispa.apis.app.lotus.requestor.process'));
		static::assertInstanceOf(SnippetRequestor::class, $container->getService('ispa.apis.app.lotus.requestor.snippet'));
		static::assertInstanceOf(UserRequestor::class, $container->getService('ispa.apis.app.lotus.requestor.user'));
		static::assertInstanceOf(UserGroupRequestor::class, $container->getService('ispa.apis.app.lotus.requestor.userGroup'));

		static::assertInstanceOf(LotusRootquestor::class, $container->getService('ispa.apis.app.lotus.rootquestor'));

		$rootquestor = $container->getService('ispa.apis.app.lotus.rootquestor');
		assert($rootquestor instanceof LotusRootquestor);
		static::assertInstanceOf(CalendarRequestor::class, $rootquestor->calendar);
		static::assertInstanceOf(ProcessRequestor::class, $rootquestor->process);
		static::assertInstanceOf(SnippetRequestor::class, $rootquestor->snippet);
		static::assertInstanceOf(UserRequestor::class, $rootquestor->user);
		static::assertInstanceOf(UserGroupRequestor::class, $rootquestor->userGroup);
	}

}
