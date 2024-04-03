<?php declare(strict_types = 1);

namespace Floweye\Client\Filter\Enum;

enum InstanceVariableStringOperator: string
{

	case equal = '=';
	case notEqual = '!=';
	case like = '';
	case notLike = '!';

}
