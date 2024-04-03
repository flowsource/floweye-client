<?php declare(strict_types = 1);

namespace Floweye\Client\Filter\Enum;

enum InstanceSort: string
{

	case started = 'started';
	case modified = 'modified';
	case expired = 'expired';

}
