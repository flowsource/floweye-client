<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\InstanceClient;
use Floweye\Client\Entity\InstanceCreateEntity;
use Floweye\Client\Entity\InstanceDispatchEntity;
use Floweye\Client\Filter\InstanceListFilter;

/**
 * @property InstanceClient $client
 */
final class InstanceService extends BaseService
{

	public function __construct(InstanceClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return array<mixed>
	 */
	public function list(InstanceListFilter $filter): array
	{
		$response = $this->client->list($filter);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return array<mixed>
	 */
	public function getById(int $id): array
	{
		$response = $this->client->getById($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function create(InstanceCreateEntity $entity): array
	{
		$response = $this->client->create($entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function dispatch(int $id, InstanceDispatchEntity $entity): array
	{
		$response = $this->client->dispatch($id, $entity);

		return $this->processResponse($response)->getData();
	}

	public function upload(
		int $id,
		string $collection,
		string $fileName,
		string $contents,
		?string $mode = null
	): void
	{
		$response = $this->client->upload($id, $collection, $fileName, $contents, $mode);

		$this->assertResponse($response);
	}

}
