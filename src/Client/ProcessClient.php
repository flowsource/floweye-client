<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\ProcessDiscussionCreateEntity;
use Floweye\Client\Entity\ProcessModifyStepPlanCreateEntity;
use Floweye\Client\Filter\ProcessListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class ProcessClient extends AbstractClient
{

	private const PATH = 'processes';

	public function listProcesses(ProcessListFilter $filter): ResponseInterface
	{
		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($filter->toParameters())));
	}

	/**
	 * @param string[] $include
	 */
	public function getProcess(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH, $id, $query));
	}

	public function addTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%d/tags/%d', self::PATH, $pid, $ttid));
	}

	public function removeTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%d/tags/%d', self::PATH, $pid, $ttid));
	}

	public function moveProcessToNextStep(int $processId): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/next', self::PATH, $processId), [
			'headers' => ['Content-Type' => 'application/json'],
		]);
	}

	public function uploadFile(
		int $processId,
		string $variable,
		string $fileName,
		string $contents,
		?string $mode = null
	): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'variable' => $variable,
			'mode' => $mode,
		]);

		return $this->upload(
			sprintf('%s/%s/upload?%s', self::PATH, $processId, $query),
			$fileName,
			$contents
		);
	}

	public function modifyPlan(int $processId, string $stepSid, ProcessModifyStepPlanCreateEntity $entity): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s/plans/%s', self::PATH, $processId, $stepSid), ['json' => $entity->toBody()]);
	}

	public function createDiscussion(int $processId, ProcessDiscussionCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/discussion', self::PATH, $processId), ['json' => $entity->toBody()]);
	}

	public function uploadFileToDiscussion(
		int $processId,
		int $discussionId,
		string $fileName,
		string $contents
	): ResponseInterface
	{
		return $this->upload(
			sprintf('%s/%s/discussion/%s/upload', self::PATH, $processId, $discussionId),
			$fileName,
			$contents
		);
	}

	/**
	 * @param mixed[] $variables
	 */
	public function modifyVariables(int $processId, array $variables): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s/variables', self::PATH, $processId), ['json' => ['variables' => $variables]]);
	}

	private function upload(string $path, string $fileName, string $fileContent): ResponseInterface
	{
		return $this->request(
			'POST',
			$path,
			[
				'multipart' => [
					[
						'name' => 'File',
						'filename' => $fileName,
						'contents' => $fileContent,
					],
				],
			]
		);
	}

}
