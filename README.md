<h1 align="center">Floweye PHP SDK</h1>

<p align="center">PHP API client for <a href="https://floweye.app">Floweye</a> - <a href="https://api.floweye.app">REST API</a> - <a href="https://docs.floweye.app">Docs</a></p>

<p align=center>
  <a href="https://github.com/flowsource/floweye-client/actions"><img src="https://badgen.net/github/status/flowsource/floweye-client/"></a>
  <a href="https://coveralls.io/r/flowsource/floweye-client"><img src="https://badgen.net/coveralls/c/github/flowsource/floweye-client/"></a>
  <a href="https://packagist.org/packages/floweye/client"><img src="https://badgen.net/packagist/dm/floweye/client"></a>
  <a href="https://packagist.org/packages/floweye/client"><img src="https://badgen.net/packagist/v/floweye/client"></a>
<p>

-----


## Versions

| State     | Version      | Branch   | Nette        | PHP     |
|-----------|--------------|----------|--------------|---------|
| dev       | `^0.3.0`     | `master` | `2.4`, `3.0` | `>=7.2` |
| stable    | `^0.2.0`     | `master` | `2.4`, `3.0` | `>=7.2` |


## Instalation

Install package using Composer.

```bash
composer require floweye/client
```


## How to use


### High level

Simply inject desired services which allow you to work directly with processed data.

```php
$userService = $context->getService(Floweye\Client\Service\UserService::class);
$user = $userService->getById(1, []);
```


### PSR-7 level

In case you need to access PSR-7 response. You can work with our client layer.

```php
$userClient = $context->getService(Floweye\Client\Client\UserClient::class);

/** @var Psr\Http\Message\ResponseInterface $response */
$response = $userClient->getById(1, []);
```


### Low level

This example showcases the manual service instantiation.

```php
$guzzleFactory = $context->getService(Floweye\Client\Http\Guzzle\GuzzleFactory::class);
$httpClient = $guzzleFactory->create([
    'base_uri' => 'https://floweye.tld/api/v1/',
    'http_errors' => false,
    'headers' => [
        'X-Api-Token' => 'floweye-api-key',
    ]
]);

// You can now use $httpClient with our Clients, Services or on its own
$userClient = new Floweye\Client\Client\UserClient($httpClient);
$userService = new Floweye\Client\Service\UserService($userClient);
```


### Nette bridge

```yaml
extensions:
    # For Nette 3.0+
    floweye.api: Floweye\Client\DI\FloweyeExtension
    # For Nette 2.4
    floweye.api: Floweye\Client\DI\FloweyeExtension24

floweye.api:
    debug: %debugMode%
    http:
        base_uri: https://floweye.tld/api/v1/
        headers:
            X-Api-Token: floweye_api_key
```

Configure default http client [Guzzle HTTP client](https://guzzle.readthedocs.io/en/latest/quickstart.html) under `http` option.


## API endpoints overview

**ApplicationService**

| Method                                       | API                             |
| -------------------------------------------- | ------------------------------- |
| export($include)                             | `GET /application/export`       |
| import($data)                                | `POST /application/import`      |
| listGlobals($path)                           | `GET /application/globals`      |
| editGlobals($globals)                        | `PUT /application/globals`      |
| listSnippets($limit, $offset, $include)      | `GET /snippets`                 |
| createSnippet($name, $description, $snippet) | `POST /snippets`                |
| deleteSnippet($id)                           | `DELETE /snippets/{id}`         |


**UserService**

| Method                       | API                              |
| ---------------------------- | -------------------------------- |
| list($filter)                | `GET /users`                     |
| create($entity)              | `POST /users`                    |
| getById($id, $include)       | `GET /users/{id}`                |
| edit($id, $entity)           | `PUT /users/{id}`                |
| oneTimeLogin($id)            | `PUT /users/{id}/one-time-login` |
| passwordReset($id)           | `PUT /users/{id}/password-reset` |
| newUserToken($id)            | `PUT /users/{id}/new-user/token` |
| newUserMail($id)             | `PUT /users/{id}/new-user/mail`  |


**UserGroupService**

| Method                                                                 | API                                      |
| ---------------------------------------------------------------------- | ---------------------------------------- |
| listUserGroups($include)                                               | `GET /user-groups`                       |
| createOne($entity)                                                     | `POST /user-groups`                      |
| findOne($gid, $include)                                                | `GET /user-groups/{gid}`                 |
| editOne($gid, $entity)                                                 | `PUT /user-groups/{gid}`                 |
| deleteOne($gid)                                                        | `DELETE /user-groups/{gid}`              |
| appendUsers($gid, $userIds, $includeSystemUsers, $includeBlockedUsers) | `PATCH /user-groups/{gid}/append-users`  |


**PlanService**

| Method                          | API                    |
| ------------------------------- | ---------------------- |
| findMultiple($filters)          | `GET /plans`           |
| createOne($entity)              | `POST /plans`          |
| deleteOne($id)                  | `DELETE /plans/{id}`   |


**TimerService**

| Method                                   | API                            |
| ---------------------------------------- | ------------------------------ |
| listTimers($from, $to, $filter)          | `GET /timers/{from}/{to}`      |
| findRunning($filter)                     | `GET /timers/running`          |
| createEntry($entity)                     | `GET /timers`                  |
| editEntry($id, $entity)                  | `PUT /timers/{id}`             |
| getEntry($id, $entity)                   | `GET /timers/{id}`             |
| startEntry($id, $entity)                 | `POST /timers/{id}/start`      |
| stopEntry($id)                           | `POST /timers/{id}/stop`       |


**ProcessService**

| Method                                                                   | API                                              |
| ------------------------------------------------------------------------ | ------------------------------------------------ |
| listProcesses($filter)                                                   | `GET /processes`                                 |
| getProcess($id, $include)                                                | `GET /processes/{id}`                            |
| moveProcessToNextStep($id)                                               | `POST /processes/{id}/next`                      |
| addTag($pid, $ttid)                                                      | `POST /processes/{pid}/tags/{ttid}`              |
| removeTag($pid, $ttid)                                                   | `DELETE /processes/{pid}/tags/{ttid}`            |
| uploadFile($id, $variable, $fileName, $contents, $mode)                  | `POST /process/{id}/upload`                      |
| createDiscussion($processId, $entity)                                    | `POST /processes/{pid}/discussion`               |
| uploadFileToDiscussion($processId, $discussionId, $fileName, $contents)  | `POST /processes/{pid}/discussion/{id}/upload`   |
| modifyPlan($processId, $stepSid, $entity)                                | `PUT /processes/{pid}/plans/{sid}`               |
| modifyVariables($processId, $entity)                                     | `PUT /processes/{pid}/variables`                 |


**TemplateProcessService**

| Method                                      | API                                              |
| ------------------------------------------- | ------------------------------------------------ |
| listTemplates($filter)                      | `GET /template-processes`                        |
| getTemplate($id, $include)                  | `GET /template-processes/{id}`                   |
| createTemplate($entity)                     | `POST /template-processes`                       |
| checkTemplate($entity)                      | `POST /template-processes/check`                 |
| editTemplate($id, $entity)                  | `PUT /template-processes/{id}`                   |
| deleteTemplate($id)                         | `DELETE /template-processes/{id}`                |
| startProcess($tid, $data, $include)         | `POST /template-processes/{id}/start`            |
