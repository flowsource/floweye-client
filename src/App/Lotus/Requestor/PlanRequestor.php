<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus\Requestor;

use FlowEye\ApiClient\App\Lotus\Client\PlanClient;
use FlowEye\ApiClient\App\Lotus\Entity\PlanProcessCreateEntity;

/**
 * @property-read PlanClient $client
 */
class PlanRequestor extends BaseRequestor
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
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function findMultiple(int $limit = 10, int $offset = 0, array $include = []): array
	{
		$response = $this->client->findMultiple($limit, $offset, $include);

		return $this->processResponse($response)->getData();
	}

}
