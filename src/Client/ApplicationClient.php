<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\SnippetCreateEntity;
use Floweye\Client\Entity\SnippetEditEntity;
use Floweye\Client\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ApplicationClient extends AbstractClient
{

	protected const PATH = 'application';

	/**
	 * @param string[] $include
	 */
	public function export(array $include): ResponseInterface
	{
		$query = count($include) === 0 ? '' : Helpers::buildQuery(['include' => implode(',', $include)]);

		return $this->request('GET', sprintf('%s/export?%s', self::PATH, $query));
	}

	public function import(StreamInterface $data): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/import', self::PATH), [
			'body' => $data,
			'headers' => ['Content-Type' => 'application/json'],
		]);
	}

	public function listGlobals(string $path): ResponseInterface
	{
		$query = Helpers::buildQuery(['path' => $path]);

		return $this->request('GET', sprintf('%s/globals?%s', self::PATH, $query));
	}

	/**
	 * @param mixed[] $globals
	 */
	public function editGlobals(array $globals): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/globals', self::PATH), ['json' => $globals]);
	}

	public function createSnippet(SnippetCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/snippets', self::PATH), [
			'json' => $entity->toBody(),
		]);
	}

	public function editSnippet(int $id, SnippetEditEntity $entity): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/snippets/%s', self::PATH, $id), [
			'json' => $entity->toBody(),
		]);
	}

	public function deleteSnippet(int $id): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/snippets/%s', self::PATH, $id));
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

		return $this->request('GET', sprintf('%s/snippets?%s', self::PATH, $query));
	}

}
