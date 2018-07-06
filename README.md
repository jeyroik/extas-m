# extas-m
EXTendable State Machine

Stage flow see here: http://extas.jeyroik.ru (RU lang)

# install

```composer require jeyroik/extas-m:*```

# usage

- define generic plugins
- define all other plugins
- define machine config
- define dispatchers for your states (or you can use built-in dispatchers for test aims)
- run machine

```php
$config = [...]; // or dsn if you have db generic plugins
$extas = new jeyroik\extas\components\systmes\states\StateMachine($config);
$extas->run();
```

If you are using State route plugin (by default), you can see states route:

```php
echo '<pre>';
print_r($extas->getRoute());
echo '</pre>';
```

# extending state machine

Extas let you extend it by two dimensions:

- functionality
- stages triggering

Stages - they are like events, you can subscribe to it by plugins and then react on stage is reached.

Functionality - this is built-in opportunity for extending exactly objects interface without needs to extends them physically by class extending. 
This is reached by extensions.

## plugins

- create you plugin
- require it to you project

## extensions

- create extension
- require it to your project
