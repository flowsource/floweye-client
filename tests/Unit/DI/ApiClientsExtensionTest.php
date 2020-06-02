<?php declare(strict_types = 1);

namespace Tests\FlowEye\ApiClient\Unit\DI;

use FlowEye\ApiClient\App\Lotus\Client\CalendarClient;
use FlowEye\ApiClient\App\Lotus\Client\PlanClient;
use FlowEye\ApiClient\App\Lotus\Client\ProcessClient;
use FlowEye\ApiClient\App\Lotus\Client\SnippetClient;
use FlowEye\ApiClient\App\Lotus\Client\UserClient;
use FlowEye\ApiClient\App\Lotus\Client\UserGroupClient;
use FlowEye\ApiClient\App\Lotus\LotusRootquestor;
use FlowEye\ApiClient\App\Lotus\Requestor\CalendarRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\PlanRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\ProcessRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\SnippetRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\UserGroupRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\UserRequestor;
use FlowEye\ApiClient\DI\ApiClientsExtension;
use FlowEye\ApiClient\DI\ApiClientsExtension24;
use FlowEye\ApiClient\Http\Guzzle\GuzzleFactory;
use FlowEye\ApiClient\Http\HttpClient;
use Nette\DI\Compiler;
use Nette\DI\Definitions\ServiceDefinition;
use Tests\FlowEye\ApiClient\Toolkit\ContainerTestCase;

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
