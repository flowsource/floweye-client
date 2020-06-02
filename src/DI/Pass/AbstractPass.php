<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\DI\Pass;

use FlowEye\ApiClient\DI\ApiClientsExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

abstract class AbstractPass
{

	/** @var ApiClientsExtension */
	protected $extension;

	/** @var mixed[] */
	protected $config;

	public function __construct(ApiClientsExtension $extension)
	{
		$this->extension = $extension;
	}

	public static function getConfigSchema(): Schema
	{
		return Expect::structure([]);
	}

	/**
	 * @param mixed[] $config
	 */
	public function setConfig(array $config): void
	{
		$this->config = $config;
	}

	public function loadPassConfiguration(): void
	{
	}

	public function beforePassCompile(): void
	{
	}

	public function afterPassCompile(ClassType $class): void
	{
	}

}
