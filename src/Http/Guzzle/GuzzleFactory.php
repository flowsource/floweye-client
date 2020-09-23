<?php declare(strict_types = 1);

namespace Floweye\Client\Http\Guzzle;

use GuzzleHttp\Client;

class GuzzleFactory
{

	/**
	 * @param mixed[] $config
	 */
	public function create(array $config): GuzzleClient
	{
		// @todo $this->config['debug'] ==> Tracy panel
		// panel pro tracy máme v contributte/guzzlette - bylo by fajn nevynalézat znovu kolo. @mabar

		return new GuzzleClient(new Client($config));
	}

}
