<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use DateTimeInterface;
use Floweye\Client\Entity\ProcessDiscussionCreateEntity;
use Floweye\Client\Entity\ProcessModifyStepPlanCreateEntity;
use Floweye\Client\Filter\ProcessListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class ProcessClient extends AbstractClient
{

	private const PATH = 'processes';

	public function listProcesses(int $limit = 10, int $offset = 0, ?ProcessListFilter $filter = null): ResponseInterface
	{
		$parameters = [
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'include' => implode(',', $filter !== null ? $filter->getInclude() : []),
		];

		if ($filter !== null) {
			$state = $filter->getState();
			if ($state !== null) {
				$parameters['state'] = $state;
			}

			$creatorId = $filter->getCreatorId();
			if ($creatorId !== null) {
				$parameters['creatorId'] = $creatorId;
			}

			$resolverId = $filter->getResolverId();
			if ($creatorId !== null) {
				$parameters['resolverId'] = $resolverId;
			}

			$possibleResolverId = $filter->getPossibleResolverId();
			if ($possibleResolverId !== null) {
				$parameters['possibleResolverId'] = $possibleResolverId;
			}

			$templateId = $filter->getTemplateId();
			if ($templateId !== null) {
				$parameters['templateId'] = $templateId;
			}

			$plannedFrom = $filter->getPlannedFrom();
			if ($plannedFrom !== null) {
				$parameters['plannedFrom'] = $plannedFrom->format(DateTimeInterface::ATOM);
			}

			$plannedTo = $filter->getPlannedTo();
			if ($plannedTo !== null) {
				$parameters['plannedTo'] = $plannedTo->format(DateTimeInterface::ATOM);
			}

			$variables = $filter->getVariables();
			if ($variables !== null) {
				$parameters['variables'] = Json::encode($variables);
			}
		}

		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($parameters)));
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
		string $contents
	): ResponseInterface
	{
		return $this->upload(
			sprintf('%s/%s/upload?variable=%s', self::PATH, $processId, $variable),
			$fileName,
			$contents
		);
	}

	public function modifyPlan(int $processId, string $stepSid, ProcessModifyStepPlanCreateEntity $entity): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s/plans/%s', self::PATH, $processId, $stepSid), [
			'body' => Json::encode($entity->toBody()),
			'headers' => ['Content-Type' => 'application/json'],
		]);
	}

	public function createDiscussion(int $processId, ProcessDiscussionCreateEntity $entity): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s/%s/discussion', self::PATH, $processId),
			[
				'body' => Json::encode($entity->toBody()),
				'headers' => ['Content-Type' => 'application/json'],
			]
		);
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
		return $this->request('PUT', sprintf('%s/%s/variables', self::PATH, $processId), [
			'body' => Json::encode(['variables' => $variables]),
			'headers' => ['Content-Type' => 'application/json'],
		]);
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
