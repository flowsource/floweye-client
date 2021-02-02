<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use DateTimeInterface;
use Floweye\Client\Entity\TimerEntryCreateEntity;
use Floweye\Client\Entity\TimerEntryEditEntity;
use Floweye\Client\Entity\TimerEntryStartEntity;
use Floweye\Client\Filter\TimerListFilter;
use Floweye\Client\Filter\TimerRunningFilter;
use Floweye\Client\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class TimerClient extends AbstractClient
{

	private const PATH = 'timers';

	public function createEntry(TimerEntryCreateEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s', self::PATH), ['json' => $entity->toBody()]);
	}

	/**
	 * @param string[] $include
	 */
	public function getEntry(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%s?%s', self::PATH, $id, $query));
	}

	public function editEntry(int $id, TimerEntryEditEntity $entity): ResponseInterface
	{
		return $this->request('PUT', sprintf('%s/%s', self::PATH, $id), ['json' => $entity->toBody()]);
	}

	public function startEntry(int $id, TimerEntryStartEntity $entity): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/start', self::PATH, $id), ['json' => $entity->toBody()]);
	}

	public function stopEntry(int $id): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%s/stop', self::PATH, $id));
	}

	public function deleteEntry(int $id): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $id));
	}

	public function findRunning(?TimerRunningFilter $filter = null): ResponseInterface
	{
		if ($filter !== null) {
			$parameters = $filter->toParameters();
		}

		return $this->request('GET', sprintf('%s/running?%s', self::PATH, Helpers::buildQuery($parameters ?? [])));
	}

	public function listTimers(DateTimeInterface $from, DateTimeInterface $to, ?TimerListFilter $filter = null): ResponseInterface
	{
		if ($filter !== null) {
			$parameters = $filter->toParameters();
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
