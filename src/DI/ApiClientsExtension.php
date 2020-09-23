<?php declare(strict_types = 1);

namespace Floweye\Client\DI;

use Floweye\Client\Client\CalendarClient;
use Floweye\Client\Client\PlanClient;
use Floweye\Client\Client\ProcessClient;
use Floweye\Client\Client\SnippetClient;
use Floweye\Client\Client\UserClient;
use Floweye\Client\Client\UserGroupClient;
use Floweye\Client\Http\Guzzle\GuzzleFactory;
use Floweye\Client\Http\HttpClient;
use Floweye\Client\Service\CalendarService;
use Floweye\Client\Service\PlanService;
use Floweye\Client\Service\ProcessService;
use Floweye\Client\Service\SnippetService;
use Floweye\Client\Service\UserGroupService;
use Floweye\Client\Service\UserService;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * @method mixed[] getConfig()
 * @property-read mixed[] $config
 */
class ApiClientsExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'debug' => Expect::bool(false),
			'http' => Expect::structure([
				'http_errors' => Expect::bool(false),
				'base_uri' => Expect::string()->required(),
				'headers' => Expect::structure([
					'X-Api-Token' => Expect::string()->required(),
				])->castTo('array'),
			])->otherItems(Expect::mixed())
				->castTo('array'),
		])->castTo('array');
	}

	public function loadConfiguration(): void
	{
		$config = $this->getConfig();
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('guzzleFactory'))
			->setFactory(GuzzleFactory::class);

		// #1 HTTP client
		$builder->addDefinition($this->prefix('http.client'))
			->setFactory($this->prefix('@guzzleFactory::create'), [$config['http']])
			->setType(HttpClient::class)
			->setAutowired(false);

		// #2 Clients
		$builder->addDefinition($this->prefix('client.calendar'))
			->setFactory(CalendarClient::class, [$this->prefix('@http.client')]);
		$builder->addDefinition($this->prefix('client.plan'))
			->setFactory(PlanClient::class, [$this->prefix('@http.client')]);
		$builder->addDefinition($this->prefix('client.process'))
			->setFactory(ProcessClient::class, [$this->prefix('@http.client')]);
		$builder->addDefinition($this->prefix('client.snippet'))
			->setFactory(SnippetClient::class, [$this->prefix('@http.client')]);
		$builder->addDefinition($this->prefix('client.user'))
			->setFactory(UserClient::class, [$this->prefix('@http.client')]);
		$builder->addDefinition($this->prefix('client.userGroup'))
			->setFactory(UserGroupClient::class, [$this->prefix('@http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->prefix('requestor.calendar'))
			->setFactory(CalendarService::class, [$this->prefix('@client.calendar')]);
		$builder->addDefinition($this->prefix('requestor.plan'))
			->setFactory(PlanService::class, [$this->prefix('@client.plan')]);
		$builder->addDefinition($this->prefix('requestor.process'))
			->setFactory(ProcessService::class, [$this->prefix('@client.process')]);
		$builder->addDefinition($this->prefix('requestor.snippet'))
			->setFactory(SnippetService::class, [$this->prefix('@client.snippet')]);
		$builder->addDefinition($this->prefix('requestor.user'))
			->setFactory(UserService::class, [$this->prefix('@client.user')]);
		$builder->addDefinition($this->prefix('requestor.userGroup'))
			->setFactory(UserGroupService::class, [$this->prefix('@client.userGroup')]);
	}

}
