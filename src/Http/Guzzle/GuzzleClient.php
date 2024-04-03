<?php declare(strict_types = 1);

namespace Floweye\Client\Http\Guzzle;

use Floweye\Client\Exception\Runtime\RequestException;
use Floweye\Client\Http\HttpClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient implements HttpClient
{

	private GuzzleClientInterface $guzzle;

	public function __construct(GuzzleClientInterface $guzzle)
	{
		$this->guzzle = $guzzle;
	}

	/**
	 * @param mixed[] $options
	 */
	public function request(string $method, string $uri, array $options = []): ResponseInterface
	{
		try {
			return $this->guzzle->request($method, $uri, $options);
		} catch (GuzzleException $e) {
			throw new RequestException($e->getMessage(), 0, $e);
		}
	}

}
