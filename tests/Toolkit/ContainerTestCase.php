<?php declare(strict_types = 1);

namespace Tests\Floweye\Client\Toolkit;

use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Nette\DI\Extensions\ExtensionsExtension;

abstract class ContainerTestCase extends TestCase
{

	/** @var Container */
	private $container;

	protected function getContainer(): Container
	{
		if (!$this->container) {
			$this->container = $this->createContainer();
			$this->setUpContainer($this->container);
		}

		return $this->container;
	}

	protected function createContainer(): Container
	{
		// Create container
		$loader = new ContainerLoader(self::TEMP_DIR);
		$class = $loader->load(function (Compiler $compiler): void {
			$compiler->addExtension('extensions', new ExtensionsExtension());

			// Call decorated method
			$this->setUpCompileContainer($compiler);
		});

		// Create test container
		return new $class();
	}

	protected function setUpContainer(Container $container): void
	{
	}

	protected function setUpCompileContainer(Compiler $compiler): void
	{
	}

}
