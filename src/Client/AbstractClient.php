<?php declare(strict_types = 1);

namespace Floweye\Client\Client;

use Floweye\Client\Exception\LogicalException;
use Floweye\Client\Http\HttpClient;
use Nette\Utils\Validators;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractClient
{

	protected ?string $sudo = null;

	protected HttpClient $httpClient;

	public function __construct(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	public function enableSudo(string $email): void
	{
		if (!Validators::isEmail($email)) {
			throw new LogicalException('You must provide valid email when enabling sudo');
		}

		$this->sudo = $email;
	}

	public function disableSudo(): void
	{
		$this->sudo = null;
	}

	public function isSudo(): bool
	{
		return $this->sudo !== null;
	}

	/**
	 * @param mixed[] $options
	 */
	public function request(string $method, string $uri, array $options = []): ResponseInterface
	{
		if ($this->isSudo()) {
			$options = array_merge_recursive($options, ['headers' => ['X-Sudo' => $this->sudo]]);
		}

		return $this->httpClient->request($method, $uri, $options);
	}

}
