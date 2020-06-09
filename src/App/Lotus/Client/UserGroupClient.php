<?php declare(strict_types = 1);

namespace Floweye\Client\App\Lotus\Client;

use Floweye\Client\App\Lotus\Entity\UserGroupCreateEntity;
use Floweye\Client\App\Lotus\Entity\UserGroupEditEntity;
use Floweye\Client\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class UserGroupClient extends AbstractLotusClient
{

	private const PATH = 'user-groups';

	/**
	 * @param int[] $userIds
	 */
	public function appendUsers(string $id, array $userIds, bool $includeSystemUsers = false, bool $includeBlockedUsers = false): ResponseInterface
	{
		$query = [
			'system' => $includeSystemUsers ? 'true' : 'false',
			'blocked' => $includeBlockedUsers ? 'true' : 'false',
		];
		$query = Helpers::buildQuery($query);

		return $this->request(
			'PATCH',
			sprintf('%s/%s/append-users?%s', self::PATH, $id, $query),
			[
				'body' => Json::encode([
					'ids' => $userIds,
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	/**
	 * @param string[] $include
	 */
	public function findOne(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH, $id, $query));
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

	public function editOne(UserGroupEditEntity $entity): ResponseInterface
	{
		return $this->request(
			'PUT',
			sprintf('%s/%s', self::PATH, $entity->getId()),
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

	public function deleteOne(int $id): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $id));
	}

}
