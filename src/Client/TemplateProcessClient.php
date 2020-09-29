<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Filter\TemplateListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class TemplateProcessClient extends AbstractClient
{

	private const PATH = 'template-processes';

	public function listTemplates(TemplateListFilter $filter): ResponseInterface
	{
		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($filter->toParameters())));
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
		return $this->request('POST', sprintf('%s', self::PATH), ['json' => ['template' => $template]]);
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

		return $this->request('POST', sprintf('%s/%s/start-process?%s', self::PATH, $tid, $query), ['json' => $data]);
	}

}
