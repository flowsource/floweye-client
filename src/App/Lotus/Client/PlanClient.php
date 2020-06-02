<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Client;

use FlowEye\ApiClient\App\Lotus\Entity\PlanProcessCreateEntity;
use FlowEye\ApiClient\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class PlanClient extends AbstractLotusClient
{

	private const PATH = 'plans';

	public function createOne(PlanProcessCreateEntity $entity): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s', self::PATH),
			[
				'body' => Json::encode([
					'name' => $entity->getName(),
					'cron' => $entity->getCron(),
					'formula' => $entity->getFormula(),
					'state' => $entity->getState(),
					'template_id' => $entity->getTemplateId(),
					'creator_id' => $entity->getCreatorId(),
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function deleteOne(int $id): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $id));
	}

	/**
	 * @param string[] $include
	 */
	public function findMultiple(int $limit = 10, int $offset = 0, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'include' => implode(',', $include),
		]);
		return $this->request('GET', sprintf('%s?%s', self::PATH, $query));
	}

}
