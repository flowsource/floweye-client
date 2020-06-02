<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Requestor;

use FlowEye\ApiClient\App\Lotus\Client\ProcessClient;
use FlowEye\ApiClient\App\Lotus\Filter\ProcessListFilter;

/**
 * @property ProcessClient $client
 */
final class ProcessRequestor extends BaseRequestor
{

	public function __construct(ProcessClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function listProcesses(int $limit = 10, int $offset = 0, ?ProcessListFilter $filter = null): array
	{
		$response = $this->client->listProcesses($limit, $offset, $filter);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function getProcess(int $id, array $include = []): array
	{
		$response = $this->client->getProcess($id, $include);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function addTag(int $pid, int $ttid): array
	{
		$response = $this->client->addTag($pid, $ttid);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function removeTag(int $pid, int $ttid): array
	{
		$response = $this->client->removeTag($pid, $ttid);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function moveProcessToNextStep(int $processId): array
	{
		$response = $this->client->moveProcessToNextStep($processId);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function uploadFile(
		int $processId,
		string $variable,
		string $fileName,
		string $contents
	): array
	{
		$response = $this->client->uploadFile($processId, $variable, $fileName, $contents);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function uploadFileToDiscussion(
		int $processId,
		int $discussionId,
		string $fileName,
		string $contents
	): array
	{
		$response = $this->client->uploadFileToDiscussion($processId, $discussionId, $fileName, $contents);

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

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function listTemplates(int $limit = 10, int $offset = 0, bool $startableOnly = false, array $include = []): array
	{
		$response = $this->client->listTemplates($limit, $offset, $startableOnly, $include);

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

}
