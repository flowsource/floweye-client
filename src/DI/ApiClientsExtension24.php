<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\DI;

use FlowEye\ApiClient\DI\Pass\AbstractPass;
use FlowEye\ApiClient\DI\Pass\AppLotusPass;
use Nette\Utils\Validators;

class ApiClientsExtension24 extends ApiClientsExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => false,
		'app' => [
			AppLotusPass::APP_NAME => null,
		],
	];

	public function loadConfiguration(): void
	{
		// Validate config on top level
		$config = $this->validateConfig($this->defaults);

		// Validate right structure of app
		Validators::assertField($config, 'app', 'array');

		// Validate allowed apps
		$this->validateConfig($this->defaults['app'], $config['app']);

		// Instantiate enabled passes
		foreach ($this->map as $passName => $passClass) {
			$passConfig = $config['app'][$passName] ?? null;
			if ($passConfig === null) {
				continue;
			}

			/** @var AbstractPass $pass */
			$this->passes[] = $pass = new $passClass($this);
			$pass->setConfig($passConfig);
		}

		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->loadPassConfiguration();
		}
	}

}
