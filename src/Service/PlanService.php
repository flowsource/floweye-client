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

	public function deleteOne(int $id): void
	{
		$response = $this->client->deleteOne($id);

		$this->assertResponse($response);
	}

	/**
	 * @return mixed[]
	 */
	public function findMultiple(PlanListFilter $filter): array
	{
		$response = $this->client->findMultiple($filter);

		return $this->processResponse($response)->getData();
	}

}
