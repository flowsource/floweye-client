<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Filter\TemplateListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class TemplateProcessClient extends AbstractClient
{

	private const PATH = 'template-processes';

	public function listTemplates(int $limit = 10, int $offset = 0, ?TemplateListFilter $filter = null): ResponseInterface
	{
		$params = [
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'include' => implode(',', $filter !== null ? $filter->getInclude() : []),
		];

		if ($filter !== null) {
			if ($filter->getStartableOnly() !== null) {
				$params['startableOnly'] = $filter->getStartableOnly();
			}

			if ($filter->getState() !== null) {
				$params['state'] = $filter->getState();
			}
		}

		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($params)));
	}

	/**
	 * @param string[] $include
	 */
	public function getTemplate(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH, $id, $query));
	}

	public function createTemplate(string $template): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s', self::PATH),
			[
				'body' => Json::encode([
					'template' => $template,
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function deleteTemplate(int $templateId): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $templateId));
	}

	public function archiveTemplate(int $templateId): ResponseInterface
	{
		return $this->request('PATCH', sprintf('%s/%s/archive', self::PATH, $templateId));
	}

	/**
	 * @param mixed[] $data
	 * @param string[] $include
	 */
	public function startProcess(int $tid, array $data = [], array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request(
			'POST',
			sprintf('%s/%s/start-process?%s', self::PATH, $tid, $query),
			[
				'body' => Json::encode($data),
				'headers' => ['Content-Type' => 'application/json'],
			]
		);
	}

}
