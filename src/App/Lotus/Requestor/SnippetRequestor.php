<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Requestor;

use FlowEye\ApiClient\App\Lotus\Client\SnippetClient;

/**
 * @property SnippetClient $client
 */
class SnippetRequestor extends BaseRequestor
{

	public function __construct(SnippetClient $client)
	{
		parent::__construct($client);
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
