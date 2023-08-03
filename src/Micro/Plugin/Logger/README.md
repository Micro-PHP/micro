# Micro Framework - The minimum kernel for application initialization.

### Requirements

PHP  >= 8.0.0

### How to use the library

Add the latest version of micro/kernel into your project by using Composer or manually:

__Using Composer (Recommended)__

Or require the package inside the composer.json of your project:
```
"require": {
    "micro/kernel": "^1"
},
```

### Example

After adding the library to your project, include the file autoload.php found in root of the library.
```html
include 'vendor/autoload.php';
```

#### Configuration



#### Simple usage:

```php

$plugins = [
    \Micro\Plugin\Logger\LoggerPlugin::class,
];
```

## License

[MIT](LICENSE)