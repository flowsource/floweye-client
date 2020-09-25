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

| State  | Version      | Branch   | Nette        | PHP     |
|--------|--------------|----------|--------------|---------|
| dev    | `^0.1.0`     | `master` | `2.4`, `3.0` | `>=7.2` |

## Setup

Install package using Composer.

```bash
composer require floweye/client
```

Register DI extension in your NEON file.

```yaml
extensions:
    # For Nette 3.0+
    floweye.api: Floweye\Client\DI\ApiClientsExtension
    # For Nette 2.4
    floweye.api: Floweye\Client\DI\ApiClientsExtension24

floweye.api:
    debug: %debugMode%
    http:
        base_uri: https://floweye.tld/api/v1/
        headers:
            X-Api-Token: floweye_api_key
```

Configure connection under key `http` configure [Guzzle HTTP client]([Guzzle doc](https://guzzle.readthedocs.io/en/latest/quickstart.html)).

## How to use

### High level

For high level usage you simply inject desired service and work directly with prepared data.

```php
/** @var UserService @inject */
public $users;

public function magic(): void
{
    $user = $this->users->getById(1);
}
```

### Psr-7 response level

In case you need specific response information. You can work with our client layer.

```php
/** @var UserClient @inject */
public $users;

public function magic(): void
{
    $response = $this->users->getById(1);
}
```

### Low level

```php
/** @var GuzzleFactory @inject */
public $guzzleFactory;

public function magic(): void
{
    $guzzleClient = $this->guzzleFactory->create([
        'base_uri' => 'https://floweye.tld/api/v1/',
        'http_errors' => false,
        'headers' => [
            'X-Api-Token' => 'floweye-api-key',
        ]
    ]);

    // You can now use $guzzleClient with our Clients, Services or on its own
    $client = new UserClient($guzzleClient);
    $service = new UserService($client);
}
```

## API endpoints overview

** ApplicationService **

| Method                                       | API                             |
| -------------------------------------------- | ------------------------------- |
| export($include)                             | `GET /application/export`       |
| import($data)                                | `POST /application/import`      |
| listGlobals($path)                           | `GET /application/globals`      |
| editGlobals($globals)                                | `PUT /application/globals`      |
| listSnippets($limit, $offset, $include)      | `GET /snippets`                 |
| createSnippet($name, $description, $snippet) | `POST /snippets`                |
| deleteSnippet($id)                           | `DELETE /snippets/{id}`         |

**UserService**

| Method                         | API path                    | Type   |
| ------------------------------ | --------------------------- | ------ |
| list($limit, $offset, $filter) | /users                      | GET    |
| getById($id)                   | /users/{id}                 | GET    |
| create($entity)                | /users                      | POST   |
| edit($entity)                  | /users/{id}                 | PUT    |

**UserGroupService**

| Method                                                                | API path                       | Type   |
| --------------------------------------------------------------------- | ------------------------------ | ------ |
| appendUsers($id, $userIds, $includeSystemUsers, $includeBlockedUsers) | /user-groups/{id}/append-users | PATCH  |
| findOne($id, $include)                                                | /user-groups/{id}              | GET    |
| createOne($entity)                                                    | /user-groups                   | POST   |
| editOne($entity)                                                      | /user-groups/{id}              | PUT    |
| deleteOne($id)                                                        | /user-groups/{id}              | DELETE |

**PlanService**

| Method                                  | API path    | Type   |
| --------------------------------------- | ----------- | ------ |
| findMultiple($limit, $offset, $filters) | /plans      | GET    |
| createOne($entity)                      | /plans      | POST   |
| deleteOne($id)                          | /plans/{id} | DELETE |

**CalendarService**

| Method         | API path       | Type   |
| -------------- | -------------- | ------ |
| getFolder($id) | /calendar/{id} | GET    |

**ProcessService**

| Method                                                    | API path                           | Type   |
| ----------------------------------------------------------| ---------------------------------- | ------ |
| listProcesses($limit, $offset, $filter, $include)         | /processes                         | GET    |
| getProcess($id, $include)                                 | /processes/{id}                    | GET    |
| addTag($pid, $ttid)                                       | /processes/{pid}/tags/{ttid}       | POST   |
| removeTag($pid, $ttid)                                    | /processes/{pid}/tags/{ttid}       | DELETE |
| moveProcessToNextStep($id)                                | /processes/{id}/next               | POST   |
| uploadFile($id, $variable, $fileName, $contents)          | /process/{id}/upload               | POST   |
| listTemplates($limit, $offset, $startableOnly, $include)  | /template-processes                | GET    |
| getTemplate($id, $include)                                | /template-processes/{id}           | GET    |
| createTemplate($entity)                                   | /template-processes                | POST   |
| deleteTemplate($id)                                       | /template-processes/{id}           | DELETE |
| archiveTemplate($id)                                      | /template-processes/{id}/archive   | PATCH  |
| startProcess($tid, $data, $include)                       | /template-processes/{id}/start     | POST   |

*1 Note: listProcesses $filter expects $variables to be array of variables to search for in format ["name" => "value", ...] eg ["user" => "10", "status" => "active"]

*2 Note: startProcess detailed info:

StartProcess method accepts an optional parameter $data with which you can set process default variables, assign users to roles etc.

Please see example of $data with comments below:

```php
$data = [
    // set values to process variables
    'variables' => [
        'foo' => 'bar',
        'baz' => 'bat',
    ],
    // assign users to roles by their user ids and role names
    'roles' => [
        'medic' => [152578, 24557],
        'coroner' => [666]
    ],
    // how many times the process should proceed to next step automatically
    'next' => 2,
];
```
