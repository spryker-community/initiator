# initiator
Run:
mkdir spryker-community
cd spryker-community
git clone git@github.com:spryker-community/initiator.git ./initiator

Put in demoshop composer json:

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

Then run:
docker/sdk cli composer i
docker/sdk cli composer update

Then put in config_default.php:
$config[KernelConstants::PROJECT_NAMESPACES] = [
'Pyz',
'Initiator'
];

Then put in Zed ConsoleDependencyProvider at the right place:
new StoreCreatorConsole(),
