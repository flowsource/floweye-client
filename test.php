<?php declare(strict_types = 1);


require_once "vendor/autoload.php";

$loader = new \Nette\DI\ContainerLoader(__DIR__ . '/tmp', TRUE);
$class = $loader->load(function (\Nette\DI\Compiler $compiler): void {
	$compiler->addExtension('ispa.apis', new \Floweye\Client\DI\ApiClientsExtension());
	$compiler->addConfig([
		'ispa.apis' => [
			'http' => [
				'base_uri' => 'http://localhost:8010/api/v1/',
				'headers' => [
					'X-Api-Token' => '1a19f09e5836870aa1494c08820721d23acf4c2fd1450263fc28d1629a94a78b8bbe8dbb0a7687a48c0abbd7a603df07',
				],
			],
		],
	]);
});

/** @var \Nette\DI\Container $container */
$container = new $class;

$list = new \Floweye\Client\Entity\ProcessModifyStepPlanCreateEntity(
	'\'2020/09/20\'', '\'2020/09/21\'', true
);

//try {
//	var_dump($container->getByType(\Floweye\Client\Client\ProcessClient::class)->listProcesses(4, $discussion)->getBody()->getSize());
//} catch (\Floweye\Client\Exception\Runtime\ResponseException $e) {
//	var_dump($e);
//	var_dump($e->getResponse()->getBody()->getContents());
//}

try {
	var_dump($container->getByType(\Floweye\Client\Service\ProcessService::class)->modifyVariables(4, ['jk' => null]));
} catch (\Floweye\Client\Exception\Runtime\ResponseException $e) {
	var_dump($e);
	var_dump($e->getResponse()->getBody()->getContents());
}
