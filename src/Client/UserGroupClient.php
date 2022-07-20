<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\UserGroupCreateEntity;
use Floweye\Client\Entity\UserGroupEditEntity;
use Floweye\Client\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class UserGroupClient extends AbstractClient
{

	private const PATH = 'user-groups';

	/**
	 * @param string[] $include
	 */
	public function listUserGroups(array $include = []): ResponseInterface
	{
		$parameters = [
			'include' => implode(',', $include),
		];

		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($parameters)));
	}

	/**
	 * @param int[] $userIds
	 */
	public function appendUsers(string $gid, array $userIds, bool $includeSystemUsers = false, bool $includeBlockedUsers = false): ResponseInterface
	{
		$params = [
			'system' => $includeSystemUsers ? 'true' : 'false',
			'blocked' => $includeBlockedUsers ? 'true' : 'false',
		];

		return $this->request('PATCH', sprintf('%s/%s/append-users?%s', self::PATH, $gid, Helpers::buildQuery($params)), ['json' => ['ids' => $userIds]]);
	}

	/**
	 * @param int[] $userIds
	 */
	public function detachUsers(string $gid, array $userIds): ResponseInterface
	{
		return $this->request('PATCH', sprintf('%s/%s/detach-users', self::PATH, $gid), ['json' => ['ids' => $userIds]]);
	}

	/**
	 * @param string[] $include
	 */
	public function findOne(string $gid, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH, $gid, $query));
	}

	public function createOne(UserGroupCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s', self::PATH), ['json' => $entity->toBody()]);
	}

	public function editOne(string $gid, UserGroupEditEntity $entity): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s', self::PATH, $gid), ['json' => $entity->toBody()]);
	}

	public function deleteOne(string $gid): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $gid));
	}

}
