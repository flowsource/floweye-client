<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\TemplateProcessClient;
use Floweye\Client\Filter\TemplateListFilter;

/**
 * @property TemplateProcessClient $client
 */
class TemplateProcessService extends BaseService
{

	public function __construct(TemplateProcessClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function listTemplates(int $limit = 10, int $offset = 0, ?TemplateListFilter $filter = null): array
	{
		$response = $this->client->listTemplates($limit, $offset, $filter);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function getTemplate(int $id, array $include = []): array
	{
		$response = $this->client->getTemplate($id, $include);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function createTemplate(string $template): array
	{
		$response = $this->client->createTemplate($template);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function deleteTemplate(int $templateId): array
	{
		$response = $this->client->deleteTemplate($templateId);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function archiveTemplate(int $templateId): array
	{
		$response = $this->client->archiveTemplate($templateId);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param mixed[]  $data
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function startProcess(int $tid, array $data = [], array $include = []): array
	{
		$response = $this->client->startProcess($tid, $data, $include);

		return $this->processResponse($response)->getData();
	}

}
