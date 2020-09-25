<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\UserCreateEntity;
use Floweye\Client\Entity\UserEditEntity;
use Floweye\Client\Filter\UserListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractClient
{

	private const PATH = 'users';

	public function list(int $limit = 10, int $offset = 0, ?UserListFilter $filter = null): ResponseInterface
	{
		$parameters = [
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'include' => implode(',', $filter !== null ? $filter->getInclude() : []),
		];

		if ($filter !== null) {
			$state = $filter->getState();
			if ($state !== null) {
				$parameters['state'] = $state;
			}

			$email = $filter->getEmail();
			if ($email !== null) {
				$parameters['email'] = $email;
			}

			$id = $filter->getId();
			if ($id !== null) {
				$parameters['id'] = $id;
			}

			$username = $filter->getUsername();
			if ($username !== null) {
				$parameters['username'] = $username;
			}
		}

		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($parameters)));
	}

	/**
	 * @param string[] $include
	 */
	public function getById(int $id, array $include): ResponseInterface
	{
		$parameters = ['include' => implode(',', $include)];

		return $this->request('GET', sprintf('%s/%s?%s', self::PATH, $id, Helpers::buildQuery($parameters)));
	}

	public function create(UserCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s', self::PATH), [
			'body' => Json::encode($entity->toBody()),
			'headers' => ['Content-Type' => 'application/json'],
		]);
	}

	public function edit(int $id, UserEditEntity $entity): ResponseInterface
	{
		return $this->request(
			'PUT',
			sprintf('%s/%s', self::PATH, $id),
			[
				'body' => Json::encode($entity->toBody()),
				'headers' => ['Content-Type' => 'application/json'],
			]
		);
	}

	public function oneTimeLogin(int $id): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s/one-time-login', self::PATH, $id));
	}

	public function passwordReset(int $id): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s/password-reset', self::PATH, $id));
	}

}
