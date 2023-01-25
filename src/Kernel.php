<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Micro\Framework\Kernel\Configuration\DefaultApplicationConfiguration;
use Micro\Kernel\App\AppKernel;

$basedir = realpath(__DIR__.'/../');
if (!$basedir) {
    throw new \RuntimeException('Base path can not be resolved.');
}

require_once $basedir.'/vendor/autoload.php';

return function () use ($basedir): \Micro\Framework\Kernel\KernelInterface {
    $applicationConfiguration = new class($basedir) extends DefaultApplicationConfiguration {
        private readonly Dotenv $dotenv;

        public function __construct(string $basePath)
        {
            $_ENV['BASE_PATH'] = $basePath;

            $env = getenv('APP_ENV') ?: 'dev';

            $envFileCompiled = $basePath.'/.env.'.$env.'.php';
            if (file_exists($envFileCompiled)) {
                $content = include $envFileCompiled;
                parent::__construct($content);

                return;
            }

            $names[] = '.env';
            $names[] = '.env.'.$env;

            $this->dotenv = Dotenv::createMutable($basePath, $names, false);
            $this->dotenv->load();

            parent::__construct($_ENV);
        }
    };

    return new AppKernel(
        $applicationConfiguration,
        include $basedir.'/etc/plugins.php',
        $applicationConfiguration->get('APP_ENV', 'dev')
    );
};
