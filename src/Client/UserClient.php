<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\UserCreateEntity;
use Floweye\Client\Entity\UserEditEntity;
use Floweye\Client\Filter\UserListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractClient
{

	private const PATH = 'users';

	public function list(UserListFilter $filter): ResponseInterface
	{
		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($filter->toParameters())));
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
		return $this->request('POST', sprintf('%s', self::PATH), ['json' => $entity->toBody()]);
	}

	public function edit(int $id, UserEditEntity $entity): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s', self::PATH, $id), ['json' => $entity->toBody()]);
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
