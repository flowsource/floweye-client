<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Client;

use FlowEye\ApiClient\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class SnippetClient extends AbstractLotusClient
{

	private const PATH = 'snippets';

	public function createSnippet(string $name, string $description, string $snippet): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s', self::PATH),
			[
				'body' => Json::encode([
					'name' => $name,
					'description' => $description,
					'snippet' => $snippet,
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function deleteSnippet(int $id): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $id));
	}

	/**
	 * @param string[] $include
	 */
	public function listSnippets(int $limit = 10, int $offset = 0, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'include' => implode(',', $include),
		]);
		return $this->request('GET', sprintf('%s?%s', self::PATH, $query));
	}

}
