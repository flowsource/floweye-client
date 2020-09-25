<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\PlanClient;
use Floweye\Client\Entity\PlanProcessCreateEntity;
use Floweye\Client\Filter\PlanListFilter;

/**
 * @property-read PlanClient $client
 */
class PlanService extends BaseService
{

	public function __construct(PlanClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function createOne(PlanProcessCreateEntity $entity): array
	{
		$response = $this->client->createOne($entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function deleteOne(int $id): array
	{
		$response = $this->client->deleteOne($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function findMultiple(int $limit = 10, int $offset = 0, ?PlanListFilter $filter = null): array
	{
		$response = $this->client->findMultiple($limit, $offset, $filter);

		return $this->processResponse($response)->getData();
	}

}
