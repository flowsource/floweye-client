<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\AbstractClient;
use Floweye\Client\Entity\Response;
use Floweye\Client\Exception\Runtime\ResponseException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Psr\Http\Message\ResponseInterface;

class BaseService
{

	/** @var AbstractClient */
	protected $client;

	public function __construct(AbstractClient $client)
	{
		$this->client = $client;
	}

	public function enableSudo(string $email): void
	{
		$this->client->enableSudo($email);
	}

	public function disableSudo(): void
	{
		$this->client->disableSudo();
	}

	public function isSudo(): bool
	{
		return $this->client->isSudo();
	}

	protected function processResponse(ResponseInterface $response): Response
	{
		$this->assertResponse($response);

		try {
			$resp = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);
		} catch (JsonException $e) {
			throw new ResponseException($response, 'Response is not valid JSON.');
		}

		if (!isset($resp['status'])) {
			throw new ResponseException($response, 'Missing "status" field in response data');
		}

		$appResp = new Response(
			$resp['status'],
			$resp['data'] ?? null,
			$resp['code'] ?? null,
			$resp['message'] ?? null,
			$resp['context'] ?? null
		);

		if (!$appResp->isSuccess()) {
			throw new ResponseException(
				$response,
				sprintf('API error. Status: %s, Message: %s', $appResp->getStatus(), $appResp->getMessage())
			);
		}

		return $appResp;
	}

	protected function assertResponse(ResponseInterface $response): void
	{
		if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
			throw new ResponseException($response);
		}
	}

}
