<?php declare(strict_types = 1);

namespace Floweye\Client\DI;

use Floweye\Client\Client\ApplicationClient;
use Floweye\Client\Client\PlanClient;
use Floweye\Client\Client\ProcessClient;
use Floweye\Client\Client\TemplateProcessClient;
use Floweye\Client\Client\TimerClient;
use Floweye\Client\Client\UserClient;
use Floweye\Client\Client\UserGroupClient;
use Floweye\Client\Http\Guzzle\GuzzleFactory;
use Floweye\Client\Http\HttpClient;
use Floweye\Client\Service\ApplicationService;
use Floweye\Client\Service\PlanService;
use Floweye\Client\Service\ProcessService;
use Floweye\Client\Service\TemplateProcessService;
use Floweye\Client\Service\TimerService;
use Floweye\Client\Service\UserGroupService;
use Floweye\Client\Service\UserService;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * @method mixed[] getConfig()
 * @property-read mixed[] $config
 */
class FloweyeExtension extends CompilerExtension
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
				])->otherItems(Expect::mixed())
					->castTo('array'),
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
		$builder->addDefinition($this->prefix('client.application'))
			->setFactory(ApplicationClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.templateProcess'))
			->setFactory(TemplateProcessClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.plan'))
			->setFactory(PlanClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.process'))
			->setFactory(ProcessClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.user'))
			->setFactory(UserClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.userGroup'))
			->setFactory(UserGroupClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.timer'))
			->setFactory(TimerClient::class, [$this->prefix('@http.client')]);

		// #3 Services
		$builder->addDefinition($this->prefix('service.application'))
			->setFactory(ApplicationService::class, [$this->prefix('@client.application')]);

		$builder->addDefinition($this->prefix('service.templateProcess'))
			->setFactory(TemplateProcessService::class, [$this->prefix('@client.templateProcess')]);

		$builder->addDefinition($this->prefix('service.plan'))
			->setFactory(PlanService::class, [$this->prefix('@client.plan')]);

		$builder->addDefinition($this->prefix('service.process'))
			->setFactory(ProcessService::class, [$this->prefix('@client.process')]);

		$builder->addDefinition($this->prefix('service.user'))
			->setFactory(UserService::class, [$this->prefix('@client.user')]);

		$builder->addDefinition($this->prefix('service.userGroup'))
			->setFactory(UserGroupService::class, [$this->prefix('@client.userGroup')]);

		$builder->addDefinition($this->prefix('service.timer'))
			->setFactory(TimerService::class, [$this->prefix('@client.timer')]);
	}

}
