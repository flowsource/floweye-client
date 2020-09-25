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
	 * @return mixed[]
	 */
	public function modifyVariables(int $processId, array $variables): array
	{
		$response = $this->client->modifyVariables($processId, $variables);

		return $this->processResponse($response)->getData();
	}

}
