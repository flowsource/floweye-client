<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\ApplicationClient;
use Floweye\Client\Exception\Runtime\RequestException;
use Floweye\Client\Exception\Runtime\ResponseException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use function GuzzleHttp\Psr7\stream_for;

/**
 * @property ApplicationClient $client
 */
class ApplicationService extends BaseService
{

	public function __construct(ApplicationClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function export(array $include): array
	{
		$response = $this->client->export($include);

		$this->assertResponse($response);

		try {
			return Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);
		} catch (JsonException $e) {
			throw new ResponseException($response, 'Response is not valid JSON.');
		}
	}

	/**
	 * @param mixed[] $data
	 * @return mixed[]
	 */
	public function import(array $data): array
	{
		try {
			$response = $this->client->import(stream_for(Json::encode($data)));
		} catch (JsonException $e) {
			throw new RequestException('Request data cannot be encoded to JSON.');
		}

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed
	 */
	public function listGlobals(string $path)
	{
		$response = $this->client->listGlobals($path);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param mixed[] $globals
	 * @return mixed[]
	 */
	public function editGlobals(array $globals): array
	{
		$response = $this->client->editGlobals($globals);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function createSnippet(string $name, string $description, string $snippet): array
	{
		$response = $this->client->createSnippet($name, $description, $snippet);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function deleteSnippet(int $id): array
	{
		$response = $this->client->deleteSnippet($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function listSnippets(int $limit = 10, int $offset = 0, array $include = []): array
	{
		$response = $this->client->listSnippets($limit, $offset, $include);

		return $this->processResponse($response)->getData();
	}

}
