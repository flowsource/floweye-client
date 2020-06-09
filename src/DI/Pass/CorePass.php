<?php declare(strict_types = 1);

namespace Floweye\Client\DI\Pass;

use Floweye\Client\Http\Guzzle\GuzzleFactory;
use Floweye\Client\Utils\Arrays;

class CorePass extends AbstractPass
{

	private const APP_GUZZLE = [
		AppLotusPass::APP_NAME,
	];

	public function loadPassConfiguration(): void
	{
		$this->loadGuzzleConfiguration();
	}

	private function loadGuzzleConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig();

		// Is Guzzle needed?
		if (!Arrays::containsKey($config['app'], self::APP_GUZZLE)) {
			return;
		}

		$builder->addDefinition($this->extension->prefix('guzzleFactory'))
			->setFactory(GuzzleFactory::class, [$config]);
	}

}
