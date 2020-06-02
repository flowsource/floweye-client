<?php declare(strict_types = 1);

namespace FlowEye\ApiClient\Http\Utils;

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

		$parameters = array_filter($parameters, static function ($value): bool {
			return $value !== null && $value !== '';
		});

		return http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
	}

}
