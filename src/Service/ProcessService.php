<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\ProcessClient;
use Floweye\Client\Entity\ProcessDiscussionCreateEntity;
use Floweye\Client\Entity\ProcessModifyStepPlanCreateEntity;
use Floweye\Client\Filter\ProcessListFilter;

/**
 * @property ProcessClient $client
 */
final class ProcessService extends BaseService
{

	public function __construct(ProcessClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function listProcesses(ProcessListFilter $filter): array
	{
		$response = $this->client->listProcesses($filter);

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

	public function addTag(int $pid, int $ttid): void
	{
		$response = $this->client->addTag($pid, $ttid);

		$this->assertResponse($response);
	}

	public function removeTag(int $pid, int $ttid): void
	{
		$response = $this->client->removeTag($pid, $ttid);

		$this->assertResponse($response);
	}

	/**
	 * @return mixed[]|null
	 */
	public function moveProcessToNextStep(int $processId): ?array
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
	 * @return mixed[]
	 */
	public function createDiscussion(int $processId, ProcessDiscussionCreateEntity $entity): array
	{
		$response = $this->client->createDiscussion($processId, $entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function modifyPlan(int $processId, string $stepSid, ProcessModifyStepPlanCreateEntity $entity): array
	{
		$response = $this->client->modifyPlan($processId, $stepSid, $entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param mixed[] $variables
	 */
	public function modifyVariables(int $processId, array $variables): void
	{
		$response = $this->client->modifyVariables($processId, $variables);

		$this->assertResponse($response);
	}

}
