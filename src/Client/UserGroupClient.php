<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\UserGroupCreateEntity;
use Floweye\Client\Entity\UserGroupEditEntity;
use Floweye\Client\Http\Utils\Helpers;
use Nette\Utils\Json;
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

		return $this->request(
			'PATCH',
			sprintf('%s/%s/append-users?%s', self::PATH, $gid, Helpers::buildQuery($params)),
			[
				'body' => Json::encode(['ids' => $userIds]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
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
		return $this->request(
			'POST',
			sprintf('%s', self::PATH),
			[
				'body' => Json::encode([
					'gid' => $entity->getGid(),
					'name' => $entity->getName(),
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function editOne(string $gid, UserGroupEditEntity $entity): ResponseInterface
	{
		return $this->request(
			'PUT',
			sprintf('%s/%s', self::PATH, $gid),
			[
				'body' => Json::encode($entity->toBody()),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function deleteOne(string $gid): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $gid));
	}

}
