# extas-m

Пакет машины состояния для Extas'a.

# Установка

```composer require jeyroik/extas-m:*```

# Использование

## Использование демонстрационной машины состояния

Сразу же после установки можно запустить демонстрационную машину состояния:

```php
use extas\components\SystemContainer as Container;
use extas\interfaces\machines\IMachineRepository;
use extas\interfaces\machines\IMachine;

$machineRepo = Container::getItem(IMachineRepository::class);
$machine = $machineRepo->one([IMachine::FIELD__NAME => 'extas.demo']);
$machine->run('init', ['anything' => 'you want']);
```

Вы должны увидеть следующий вывод:

```text
Initialized demo machine with the context:
[
    'anything' => 'you want'
]
Set to context initialized = true
Finished demo machine with the context: 
[
    'anything' => 'you want',
    'initialized' => true
]
```

Кроме того, можно посмотреть цепочку переходов состояний из одного в другое:

```php
echo '<pre>' . print_r($machine->getDump(), true) . '</pre>;
```

Вы должны увидеть следующее:

```text
[
    [
        'state_from' => 'extas.demo.not initialized yet',
        'state_to' => 'extas.demo.init',
        'context' => [
            'anything' => 'you want'
        ]
    ],
    [
        'state_from' => 'extas.demo.init',
        'state_to' => 'extas.demo.end',
        'context' => [
            'anything' => 'you want',
            'initialized' => true
        ]    
    ]
]
```

## Создание своей машины состояния
    
### Создание конфигурации машины

Для начала необходимо сконфигурировать машину и состояния. Их необходимо указать в extas-совместимой конфигурации.

```json
{
  "machine_states": [
    {
      "name": "init",
      "title": "Инициализация",
      "description": "Состояние инициализации машины"
    },
    {
      "name": "hello",
      "title": "Привет",
      "description": "Приветствие",
      "parameters": [{"name": "text"}]
    },
    {
      "name": "space",
      "title": "Пробел",
      "description": "Состояние пробела",
      "parameters": [{"name": "text"}]
    },
    {
      "name": "end",
      "title": "Конец",
      "description": "завершающее состояние машины",
      "parameters": [{"name": "text"}]
    },
    {
      "name": "someone",
      "title": "Некто",
      "description": "Состояние незнакомца",
      "parameters": [{"name": "text"}, {"name": "user"}]
    },
    {
      "name": "print_html",
      "title": "Вывести HTML",
      "description": "Вывод HTML",
      "parameters": [{"name": "data"}]
    },
    {
      "name": "print_json",
      "title": "Вывод JSON",
      "description": "Вывод JSON",
      "parameters": [{"name": "data"}]
    }
  ],
  "machines": [
    {
      "name": "hello_world",
      "title": "Привет мир",
      "description": "Данная машина выводит приветственное сообщение миру",
      "states": [
        {
          "name": "init",
          "on_success": {"state": "hello"},
          "on_failure": {"state": "end"}
        },
        {
          "name": "hello",
          "on_success": {"state": "space"},
          "on_failure": {"state": "end"}
        },
        {
          "name": "space",
          "on_success": {"state": "world"},
          "on_failure": {"state": "end"}
        },
        {
          "name": "world",
          "on_success": {"state": "end"},
          "on_failure": {"state": "someone"}
        },
        {
          "name": "end",
          "on_success": {"machine": "sub_machine", "state": "print_html"}
        },
        {
          "name": "someone"
        }
      ]
    },
    {
      "name": "sub_machine",
      "parameters": [{"name": "text"}],
      "states": [
        {
          "name": "print_html",
          "on_failure": {"state": "print_json"}
        },
        {
          "name": "print_json"
        }
      ]
    }
  ]
}
```

- `Параметры состояния` - это необходимые для состояния параметры контекста. Если хотя бы один из параметров отсутствует в контексте, то состояние считается не валидным и его запуск будет отменён.
- `Параметры машины` - это параметры для всех состояний, используемых в данной машине. 

### Создание плагинов для состояний

Далее необходимо создать плагины для обработки состояний. 

```php
use extas\components\plugins\Plugin;

class PluginStateHello extends Plugin
{
    public function __invoke($state, &$context, $machine, &$isSuccess)
    {
        $context['text'] = $context['text'] . 'hello';
        $isSuccess = true;
    }
}

class PluginStateSpace extends Plugin
{
    public function __invoke($state, &$context, $machine, &$isSuccess)
    {
        $context['text'] = $context['text'] . ' ';
        $isSuccess = true;
    }
}

class PluginStateWorld extends Plugin
{
    public function __invoke($state, &$context, $machine, &$isSuccess)
    {
        $context['text'] = $context['text'] . 'world';
        $isSuccess = true;
    }
}
```
### Установка машины, состояний и плагинов

`/vendor/bin/extas i`

### Запуск машины состояния

```php
$machine = $machineRepo->one([IMachine::FIELD__NAME => 'hello_world'])
$machine->run('hello', ['text' => '']); // "hello world" 
/**
 * [
 *    [
 *      "state_from" => "hello_world.init",
 *      "state_to" => "hello_world.hello",
 *      "context" => [
 *        "text" => ""
 *      ]
 *    ],
 *    [
 *      "state_from" => "hello_world.hello",
 *      "state_to" => "hello_world.hello",
 *      "context" => [
 *        "text" => "hello"
 *      ]
 *    ], 
 *    [
 *      "state_from" => "hello_world.space",
 *      "state_to" => "hello_world.hello",
 *      "context" => [
 *        "text" => "hello "
 *      ]
 *    ],
 *    [
 *      "state_from" => "hello_world.world",
 *      "state_to" => "hello_world.end",
 *      "context" => [
 *        "text" => "hello world"
 *      ]
 *    ],
 *    [
 *      "state_from" => "hello_world.end",
 *      "state_to" => "sub_machine.print_html",
 *      "context" => [
 *        "text" => "hello world"
 *      ]
 *    ]
 * ] 
 */
$machine->dump();
```