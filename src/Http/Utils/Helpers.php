<?php declare(strict_types = 1);

namespace Floweye\Client\Http\Utils;

class Helpers
{

	/**
	 * @param mixed[] $parameters
	 */
	public static function buildQuery(array $parameters): string
	{
		if ($parameters === []) {
			return '';
		}

		$parameters = array_filter($parameters, static fn ($value): bool => $value !== null && $value !== '');

		return http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
	}

}
