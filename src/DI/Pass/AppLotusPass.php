<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\DI\Pass;

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
use FlowEye\ApiClient\Http\HttpClient;

class AppLotusPass extends BaseAppPass
{

	public const APP_NAME = 'lotus';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.lotus.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(false);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.lotus.client.calendar'))
			->setFactory(CalendarClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.plan'))
			->setFactory(PlanClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.process'))
			->setFactory(ProcessClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.snippet'))
			->setFactory(SnippetClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.user'))
			->setFactory(UserClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.userGroup'))
			->setFactory(UserGroupClient::class, [$this->extension->prefix('@app.lotus.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.calendar'))
			->setFactory(CalendarRequestor::class, [$this->extension->prefix('@app.lotus.client.calendar')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.plan'))
			->setFactory(PlanRequestor::class, [$this->extension->prefix('@app.lotus.client.plan')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.process'))
			->setFactory(ProcessRequestor::class, [$this->extension->prefix('@app.lotus.client.process')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.snippet'))
			->setFactory(SnippetRequestor::class, [$this->extension->prefix('@app.lotus.client.snippet')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.user'))
			->setFactory(UserRequestor::class, [$this->extension->prefix('@app.lotus.client.user')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.userGroup'))
			->setFactory(UserGroupRequestor::class, [$this->extension->prefix('@app.lotus.client.userGroup')]);

		// #4 Rootquestor
		$rootquestor = $builder->addDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->setFactory(LotusRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$rootquestor
			->addSetup('add', ['calendar', $this->extension->prefix('@app.lotus.requestor.calendar')])
			->addSetup('add', ['plan', $this->extension->prefix('@app.lotus.requestor.plan')])
			->addSetup('add', ['process', $this->extension->prefix('@app.lotus.requestor.process')])
			->addSetup('add', ['snippet', $this->extension->prefix('@app.lotus.requestor.snippet')])
			->addSetup('add', ['user', $this->extension->prefix('@app.lotus.requestor.user')])
			->addSetup('add', ['userGroup', $this->extension->prefix('@app.lotus.requestor.userGroup')]);
	}

}
