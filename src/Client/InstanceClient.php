<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Entity\InstanceCreateEntity;
use Floweye\Client\Entity\InstanceDispatchEntity;
use Floweye\Client\Filter\InstanceListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Floweye\Client\Utils\File;
use Psr\Http\Message\ResponseInterface;

class InstanceClient extends AbstractClient
{

	private const PATH = 'instances';

	public function list(InstanceListFilter $filter): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/search', self::PATH), [
			'json' => $filter->toBody(),
		]);
	}

	public function getById(int $id): ResponseInterface
	{
		return $this->request('GET', sprintf('%s/%s', self::PATH, $id));
	}

	public function create(InstanceCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s', self::PATH), ['json' => $entity->toBody()]);
	}

	public function dispatch(int $id, InstanceDispatchEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/dispatch', self::PATH, $id), ['json' => $entity->toBody()]);
	}

	public function upload(int $id, string $collection, string $fileName, string $fileContent, ?string $mode = null): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/upload?%s', self::PATH, $id, Helpers::buildQuery([
			'collection' => $collection,
			'mode' => $mode,
		])), File::multipart($fileName, $fileContent));
	}

}
