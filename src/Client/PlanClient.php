<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\PlanProcessCreateEntity;
use Floweye\Client\Filter\PlanListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class PlanClient extends AbstractClient
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

	public function findMultiple(int $limit = 10, int $offset = 0, ?PlanListFilter $filter = null): ResponseInterface
	{
		$parameters = [
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'include' => implode(',', $filter !== null ? $filter->getInclude() : []),
		];

		if ($filter !== null) {
			if ($filter->getTemplateId() !== null) {
				$parameters['templateId'] = $filter->getTemplateId();
			}
		}

		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($parameters)));
	}

}
