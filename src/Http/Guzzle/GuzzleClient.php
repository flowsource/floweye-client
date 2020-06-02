<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\Http\Guzzle;

use FlowEye\ApiClient\Exception\Runtime\RequestException;
use FlowEye\ApiClient\Http\HttpClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient implements HttpClient
{

	/** @var GuzzleClientInterface */
	private $guzzle;

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
