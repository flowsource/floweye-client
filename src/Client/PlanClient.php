<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\PlanProcessCreateEntity;
use Floweye\Client\Filter\PlanListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class PlanClient extends AbstractClient
{

	private const PATH = 'plans';

	public function createOne(PlanProcessCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s', self::PATH), ['json' => $entity->toBody()]);
	}

	public function deleteOne(int $id): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $id));
	}

	public function findMultiple(PlanListFilter $filter): ResponseInterface
	{
		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($filter->toParameters())));
	}

}
