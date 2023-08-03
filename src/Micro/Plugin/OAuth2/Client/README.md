
# Micro Framework Oauth2 client plugin

Micro Framework: OAuth2 client based on "league/oauth2-client"
## Installation

Install plugin with composer

```bash
$ composer require micro/plugin-oauth2-client
```

And install a specific provider(s).

Available providers:
[micro/plugin-oauth2-client-keycloak]()

Аnd then add plugin to the list of plugins (etc/plugins.php)

```php

$pluginsCommon = [
    //....OTHER PLUGINS ....
    Micro\Plugin\OAuth2\Client\OAuth2ClientPlugin::class,
    Micro\Plugin\OAuth2\Client\Keycloak\OAuth2KeycloakProviderPlugin::class,
];

```
Configure your oauth2 providers

The adapter configuration template usually looks like this `MICRO_OAUTH2_<PROVIDER_NAME>_<PROVIDER_SETTING>`

Default  adapter name "default"


```dotenv
MICRO_OAUTH2_DEFAULT_TYPE=keycloak
MICRO_OAUTH2_DEFAULT_CLIENT_ID=<my-client-id>
MICRO_OAUTH2_DEFAULT_CLIENT_SECRET=<client-secret-key>
MICRO_OAUTH2_DEFAULT_CLIENT_URL_AUTHORIZATION=<auth url>
MICRO_OAUTH2_DEFAULT_CLIENT_URL_REDIRECT=<redirect url>
```


## Usage/Examples

Index document

```php

use use Micro\Plugin\OAuth2\Client\Facade\Oauth2ClientFacadeInterface;

/** Unauthorized user */ 
$client = $container->get(Oauth2ClientFacadeInterface::class);
$provider = $client->getProvider('default');

$provider->getAuthorizationUrl(); This method will return the full path to the server for user authorization.


/*** Response from the authorization server with a code */
$accessToken    = $provider->getAccessToken('authorization_code', [
    'code'  => $_GET['code'],
]);

$owner = $provider->getResourceOwner($accessToken);

$id = $owner->getId();
$ownerData = $owner->toArray(); //Associated data with the user.

```


## Support

For support, email head.trackingsoft@gmail.com.


## Authors

- [@stanislau_komar](https://www.github.com/asisyas)


## License

[MIT](LICENSE)

