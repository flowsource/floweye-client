<?php declare(strict_types = 1);

namespace Floweye\Client\DI;

use Floweye\Client\Client\ApplicationClient;
use Floweye\Client\Client\InstanceClient;
use Floweye\Client\Client\UserClient;
use Floweye\Client\Client\UserGroupClient;
use Floweye\Client\Http\Guzzle\GuzzleFactory;
use Floweye\Client\Http\HttpClient;
use Floweye\Client\Service\ApplicationService;
use Floweye\Client\Service\InstanceService;
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

		$builder->addDefinition($this->prefix('client.user'))
			->setFactory(UserClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.userGroup'))
			->setFactory(UserGroupClient::class, [$this->prefix('@http.client')]);

		$builder->addDefinition($this->prefix('client.instance'))
			->setFactory(InstanceClient::class, [$this->prefix('@http.client')]);

		// #3 Services
		$builder->addDefinition($this->prefix('service.application'))
			->setFactory(ApplicationService::class, [$this->prefix('@client.application')]);

		$builder->addDefinition($this->prefix('service.user'))
			->setFactory(UserService::class, [$this->prefix('@client.user')]);

		$builder->addDefinition($this->prefix('service.userGroup'))
			->setFactory(UserGroupService::class, [$this->prefix('@client.userGroup')]);

		$builder->addDefinition($this->prefix('service.instance'))
			->setFactory(InstanceService::class, [$this->prefix('@client.instance')]);
	}

}
