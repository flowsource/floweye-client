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
	public function list(UserListFilter $filter): array
	{
		$response = $this->client->list($filter);

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

	public function edit(int $id, UserEditEntity $entity): void
	{
		$response = $this->client->edit($id, $entity);

		$this->assertResponse($response);
	}

	public function passwordReset(int $id): void
	{
		$response = $this->client->passwordReset($id);

		$this->assertResponse($response);
	}

	public function oneTimeLogin(int $id): void
	{
		$response = $this->client->oneTimeLogin($id);

		$this->assertResponse($response);
	}

}
