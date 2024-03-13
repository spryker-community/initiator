# initiator
Run:
```bash
mkdir spryker-community
cd spryker-community
git clone git@github.com:spryker-community/initiator.git ./initiator

```

Put in demoshop composer json:

```json
"repositories": [
    {
    "type": "git",
    "url": "https://github.com/spryker/robotframework-suite-tests.git"
    },
    {
    "type": "path",
    "url": "spryker-community/initiator"
    }
],
```

Then run:
```bash
docker/sdk cli composer require --dev spryker-community/initiator
```

Then put in config_default.php:
```php
$config[KernelConstants::PROJECT_NAMESPACES] = [
    'Pyz',
    'Initiator'
];
```

Then put in Zed ConsoleDependencyProvider at the right place:
```php
new StoreCreatorConsole(),
```
