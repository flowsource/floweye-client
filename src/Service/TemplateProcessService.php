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
	public function listTemplates(TemplateListFilter $filter): array
	{
		$response = $this->client->listTemplates($filter);

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
	public function checkTemplate(string $template): array
	{
		$response = $this->client->checkTemplate($template);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function editTemplate(int $id, string $template): array
	{
		$response = $this->client->editTemplate($id, $template);

		return $this->processResponse($response)->getData();
	}

	public function deleteTemplate(int $templateId): void
	{
		$response = $this->client->deleteTemplate($templateId);

		$this->assertResponse($response);
	}

	public function archiveTemplate(int $templateId): void
	{
		$response = $this->client->archiveTemplate($templateId);

		$this->assertResponse($response);
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
