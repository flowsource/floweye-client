<?php declare(strict_types = 1);

namespace Floweye\Client\Http\Guzzle;

use GuzzleHttp\Client;

class GuzzleFactory
{

	/** @var mixed[] */
	protected $config = [];

	/** @var mixed[] */
	protected $defaults = [
		'http_errors' => false, // Disable throwing exceptions on an HTTP protocol errors (i.e., 4xx and 5xx responses)
	];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function create(string $app): GuzzleClient
	{
		// @todo $this->config['debug'] ==> Tracy panel
		// panel pro tracy máme v contributte/guzzlette - bylo by fajn nevynalézat znovu kolo. @mabar

		$config = $this->config['app'][$app]['http'] ?? [];
		$config = array_merge($this->defaults, $config);

		return new GuzzleClient(new Client($config));
	}

}
