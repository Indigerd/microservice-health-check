# microservice-health-checks module

Module have several built in health checks like db and cache


Add health check in configuration by populating checks array property

for example

```
'modules'=>[
        .........
        'healthchecks' => [
            'class' => 'indigerd\healthchecks\Module',
            'checks'=> [
                'db',
                'cache',
                'custom' => function() {
                    return (2 + 2 == 4);
                };
            ],
        ],
        .........
```