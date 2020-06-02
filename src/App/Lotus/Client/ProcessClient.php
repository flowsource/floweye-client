<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Client;

use FlowEye\ApiClient\App\Lotus\Filter\ProcessListFilter;
use FlowEye\ApiClient\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class ProcessClient extends AbstractLotusClient
{

	private const PATH_PROCESS = 'processes';
	private const PATH_TEMPLATE = 'template-processes';

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

			$possibleResolverId = $filter->getPossibleResolverId();
			if ($possibleResolverId !== null) {
				$parameters['possibleResolverId'] = $possibleResolverId;
			}

			$variables = $filter->getVariables();
			if ($variables !== null) {
				$parameters['variables'] = Json::encode($variables);
			}
		}

		return $this->request('GET', sprintf('%s?%s', self::PATH_PROCESS, Helpers::buildQuery($parameters)));
	}

	/**
	 * @param string[] $include
	 */
	public function getProcess(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH_PROCESS, $id, $query));
	}

	public function addTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%d/tags/%d', self::PATH_PROCESS, $pid, $ttid));
	}

	public function removeTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%d/tags/%d', self::PATH_PROCESS, $pid, $ttid));
	}

	public function moveProcessToNextStep(int $processId): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s/%s/next', self::PATH_PROCESS, $processId),
			[
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function uploadFile(
		int $processId,
		string $variable,
		string $fileName,
		string $contents
	): ResponseInterface
	{
		return $this->upload(
			sprintf('%s/%s/upload?variable=%s', self::PATH_PROCESS, $processId, $variable),
			$fileName,
			$contents
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
			sprintf('%s/%s/discussion/%s/upload', self::PATH_PROCESS, $processId, $discussionId),
			$fileName,
			$contents
		);
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
			sprintf('%s/%s/start-process?%s', self::PATH_TEMPLATE, $tid, $query),
			[
				'body' => Json::encode($data),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	/**
	 * @param string[] $include
	 */
	public function listTemplates(int $limit = 10, int $offset = 0, bool $startableOnly = false, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'startableOnly' => $startableOnly ? 'true' : 'false',
			'include' => implode(',', $include),
		]);
		return $this->request('GET', sprintf('%s?%s', self::PATH_TEMPLATE, $query));
	}

	/**
	 * @param string[] $include
	 */
	public function getTemplate(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH_TEMPLATE, $id, $query));
	}

	public function createTemplate(string $template): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s', self::PATH_TEMPLATE),
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
		return $this->request('DELETE', sprintf('%s/%s', self::PATH_TEMPLATE, $templateId));
	}

	public function archiveTemplate(int $templateId): ResponseInterface
	{
		return $this->request('PATCH', sprintf('%s/%s/archive', self::PATH_TEMPLATE, $templateId));
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
