<?php declare(strict_types = 1);

namespace Floweye\Client\Filter\Enum;

enum InstanceVariableNumberOperator: string
{

	case equal = '=';
	case notEqual = '!=';
	case lesser = '<';
	case greater = '>';

}
