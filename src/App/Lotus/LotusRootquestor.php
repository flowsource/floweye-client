<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\App\Lotus;

use FlowEye\ApiClient\App\Lotus\Requestor\BaseRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\CalendarRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\PlanRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\ProcessRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\SnippetRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\UserGroupRequestor;
use FlowEye\ApiClient\App\Lotus\Requestor\UserRequestor;
use FlowEye\ApiClient\Exception\Logical\InvalidStateException;

/**
 * @property-read CalendarRequestor $calendar
 * @property-read PlanRequestor $plan
 * @property-read ProcessRequestor $process
 * @property-read SnippetRequestor $snippet
 * @property-read UserRequestor $user
 * @property-read UserGroupRequestor $userGroup
 */
class LotusRootquestor
{

	/** @var BaseRequestor[] */
	private $requestors = [];

	public function add(string $name, BaseRequestor $requestor): void
	{
		if (isset($this->requestors[$name])) {
			throw new InvalidStateException(sprintf('Requestor "%s" has been already registered.', $name));
		}

		$this->requestors[$name] = $requestor;
	}

	public function __get(string $name): BaseRequestor
	{
		if (isset($this->requestors[$name])) {
			return $this->requestors[$name];
		}

		throw new InvalidStateException(sprintf('Undefined requestor "%s".', $name));
	}

}
