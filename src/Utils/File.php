<?php declare(strict_types = 1);

namespace Floweye\Client\Utils;

class File
{

	/**
	 * @return array<mixed>
	 */
	public static function multipart(string $fileName, string $fileContent): array
	{
		return [
			'multipart' => [
				[
					'name' => 'File',
					'filename' => $fileName,
					'contents' => $fileContent,
				],
			],
		];
	}

}
