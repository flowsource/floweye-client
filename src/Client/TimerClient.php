<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use DateTimeInterface;
use Floweye\Client\Entity\TimerEntryCreateEntity;
use Floweye\Client\Entity\TimerEntryEditEntity;
use Floweye\Client\Entity\TimerEntryStartEntity;
use Floweye\Client\Filter\TimerListFilter;
use Floweye\Client\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class TimerClient extends AbstractClient
{

	private const PATH = 'timers';

	public function createEntry(TimerEntryCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s', self::PATH), [
			'body' => Json::encode($entity->toBody()),
			'headers' => ['Content-Type' => 'application/json'],
		]);
	}

	public function editEntry(int $id, TimerEntryEditEntity $entity): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s', self::PATH, $id), [
			'body' => Json::encode($entity->toBody()),
			'headers' => ['Content-Type' => 'application/json'],
		]);
	}

	public function startEntry(int $id, TimerEntryStartEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/start', self::PATH, $id), [
			'body' => Json::encode($entity->toBody()),
			'headers' => ['Content-Type' => 'application/json'],
		]);
	}

	public function stopEntry(int $id): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/stop', self::PATH, $id));
	}

	public function deleteEntry(int $id): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $id));
	}

	public function findRunning(?int $resolver, ?string $timer): ResponseInterface
	{
		$parameters = [
			'resolver' => $resolver,
			'title' => $timer,
		];

		return $this->request('GET', sprintf('%s/running?%s', self::PATH, Helpers::buildQuery($parameters)));
	}

	public function listTimers(DateTimeInterface $from, DateTimeInterface $to, ?TimerListFilter $filter = null): ResponseInterface
	{
		if ($filter !== null) {
			$parameters = [
				'resolver' => $filter->getResolver(),
				'title' => $filter->getTimer(),
			];
		}

		return $this->request('GET', sprintf(
			'%s/%s/%s?%s',
			self::PATH,
			$from->format(DateTimeInterface::ATOM),
			$to->format(DateTimeInterface::ATOM),
			Helpers::buildQuery($parameters ?? [])
		));
	}

}
