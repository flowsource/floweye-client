<?php declare(strict_types = 1);

namespace Floweye\Client\DI;

use Floweye\Client\DI\Pass\AbstractPass;
use Floweye\Client\DI\Pass\AppLotusPass;
use Floweye\Client\DI\Pass\CorePass;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * @method mixed[] getConfig()
 * @property-read mixed[] $config
 */
class ApiClientsExtension extends CompilerExtension
{

	/** @var AbstractPass[] */
	protected $passes = [];

	/** @var string[] */
	protected $map = [
		AppLotusPass::APP_NAME => AppLotusPass::class,
	];

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'debug' => Expect::bool(false),
			'app' => Expect::structure([
				AppLotusPass::APP_NAME => Expect::anyOf(null, AppLotusPass::getConfigSchema()),
			])->castTo('array'),
		])->castTo('array');
	}

	public function __construct()
	{
		$this->passes[] = new CorePass($this);
	}

	public function loadConfiguration(): void
	{
		$config = $this->config;

		// Instantiate and configure enabled passes
		foreach ($this->map as $passName => $passClass) {
			$passConfig = $config['app'][$passName];
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

	public function beforeCompile(): void
	{
		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->beforePassCompile();
		}
	}

	public function afterCompile(ClassType $class): void
	{
		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->afterPassCompile($class);
		}
	}

}
