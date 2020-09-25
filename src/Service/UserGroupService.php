<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\UserGroupClient;
use Floweye\Client\Entity\UserGroupCreateEntity;
use Floweye\Client\Entity\UserGroupEditEntity;

/**
 * @property UserGroupClient $client
 */
class UserGroupService extends BaseService
{

	public function __construct(UserGroupClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function listUserGroups(array $include = []): array
	{
		$response = $this->client->listUserGroups($include);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param int[] $userIds
	 * @return mixed[]
	 */
	public function appendUsers(string $gid, array $userIds, bool $includeSystemUsers = false, bool $includeBlockedUsers = false): array
	{
		$response = $this->client->appendUsers($gid, $userIds, $includeSystemUsers, $includeBlockedUsers);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function findOne(string $gid, array $include = []): array
	{
		$response = $this->client->findOne($gid, $include);

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
	public function editOne(string $gid, UserGroupEditEntity $entity): array
	{
		$response = $this->client->editOne($gid, $entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function deleteOne(string $gid): array
	{
		$response = $this->client->deleteOne($gid);

		return $this->processResponse($response)->getData();
	}

}
