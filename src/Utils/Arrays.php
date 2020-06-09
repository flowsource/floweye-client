<?php declare(strict_types = 1);

namespace Floweye\Client\Utils;

use Nette\Utils\Arrays as NArrays;

final class Arrays extends NArrays
{

	/**
	 * @param mixed[] $array
	 * @param mixed[] $keys
	 */
	public static function containsKey(array $array, array $keys): bool
	{
		foreach ($array as $key => $value) {
			if (in_array($key, $keys, true)) {
				return true;
			}
		}

		return false;
	}

}
