<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use Floweye\Client\Client\UserClient;
use Floweye\Client\Entity\UserCreateEntity;
use Floweye\Client\Entity\UserEditEntity;
use Floweye\Client\Filter\UserListFilter;

/**
 * @property UserClient $client
 */
final class UserService extends BaseService
{

	public function __construct(UserClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function list(int $limit = 10, int $offset = 0, ?UserListFilter $filter = null): array
	{
		$response = $this->client->list($limit, $offset, $filter);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param string[] $include
	 * @return mixed[]
	 */
	public function getById(int $id, array $include): array
	{
		$response = $this->client->getById($id, $include);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function create(UserCreateEntity $entity): array
	{
		$response = $this->client->create($entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function edit(int $id, UserEditEntity $entity): array
	{
		$response = $this->client->edit($id, $entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function passwordReset(int $id): array
	{
		$response = $this->client->passwordReset($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function oneTimeLogin(int $id): array
	{
		$response = $this->client->oneTimeLogin($id);

		return $this->processResponse($response)->getData();
	}

}
