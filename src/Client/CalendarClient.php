<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Psr\Http\Message\ResponseInterface;

class CalendarClient extends AbstractLotusClient
{

	public function getFolder(int $id): ResponseInterface
	{
		return $this->request('GET', sprintf('/calendar/%d', $id));
	}

}
