<?php declare(strict_types = 1);

namespace Floweye\Client\Service;

use DateTimeInterface;
use Floweye\Client\Client\TimerClient;
use Floweye\Client\Entity\TimerEntryCreateEntity;
use Floweye\Client\Entity\TimerEntryEditEntity;
use Floweye\Client\Entity\TimerEntryStartEntity;
use Floweye\Client\Filter\TimerListFilter;

/**
 * @property TimerClient $client
 */
class TimerService extends BaseService
{

	public function __construct(TimerClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function createEntry(TimerEntryCreateEntity $entity): array
	{
		$response = $this->client->createEntry($entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function editEntry(int $id, TimerEntryEditEntity $entity): array
	{
		$response = $this->client->editEntry($id, $entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function deleteEntry(int $id): array
	{
		$response = $this->client->deleteEntry($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function startEntry(int $id, TimerEntryStartEntity $entity): array
	{
		$response = $this->client->startEntry($id, $entity);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function stopEntry(int $id): array
	{
		$response = $this->client->stopEntry($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function findRunning(?int $resolver = null, ?string $timer = null): array
	{
		$response = $this->client->findRunning($resolver, $timer);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function listTimers(DateTimeInterface $from, DateTimeInterface $to, ?TimerListFilter $filter = null): array
	{
		$response = $this->client->listTimers($from, $to, $filter);

		return $this->processResponse($response)->getData();
	}

}
