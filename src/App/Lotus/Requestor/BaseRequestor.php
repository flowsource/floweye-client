<?php declare(strict_types = 1);

namespace Floweye\Client\App\Lotus\Requestor;

use Floweye\Client\App\Lotus\Client\AbstractLotusClient;
use Floweye\Client\App\Lotus\Entity\LotusResponse;
use Floweye\Client\Exception\Runtime\ResponseException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Psr\Http\Message\ResponseInterface;

class BaseRequestor
{

	/** @var AbstractLotusClient */
	protected $client;

	public function __construct(AbstractLotusClient $client)
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

	protected function processResponse(ResponseInterface $response): LotusResponse
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

		$lotusResp = new LotusResponse(
			$resp['status'],
			$resp['data'] ?? null,
			$resp['code'] ?? null,
			$resp['message'] ?? null,
			$resp['context'] ?? null
		);

		if (!$lotusResp->isSuccess()) {
			throw new ResponseException(
				$response,
				sprintf('API error. Status: %s, Message: %s', $lotusResp->getStatus(), $lotusResp->getMessage())
			);
		}

		return $lotusResp;
	}

	/**
	 * @param int[] $allowedStatusCodes
	 */
	protected function assertResponse(ResponseInterface $response, array $allowedStatusCodes = [200]): void
	{
		if (!in_array($response->getStatusCode(), $allowedStatusCodes, true)) {
			throw new ResponseException($response);
		}
	}

}
