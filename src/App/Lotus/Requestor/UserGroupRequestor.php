<?php declare(strict_types = 1);

namespace Floweye\Client\App\Lotus\Requestor;

use Floweye\Client\App\Lotus\Client\UserGroupClient;
use Floweye\Client\App\Lotus\Entity\UserGroupCreateEntity;
use Floweye\Client\App\Lotus\Entity\UserGroupEditEntity;

/**
 * @property UserGroupClient $client
 */
class UserGroupRequestor extends BaseRequestor
{

	public function __construct(UserGroupClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @param int[] $userIds
	 * @return mixed[]
	 */
	public function appendUsers(string $id, array $userIds, bool $includeSystemUsers = false, bool $includeBlockedUsers = false): array
	{
		$response = $this->client->appendUsers($id, $userIds, $includeSystemUsers, $includeBlockedUsers);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function findOne(int $id, array $include = []): array
	{
		$response = $this->client->findOne($id, $include);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function createOne(UserGroupCreateEntity $entity): array
	{
		$response = $this->client->createOne($entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function editOne(UserGroupEditEntity $entity): array
	{
		$response = $this->client->editOne($entity);

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

}
