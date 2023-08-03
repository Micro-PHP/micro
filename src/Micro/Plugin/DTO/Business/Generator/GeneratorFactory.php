<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\DTO\Business\Generator;

use Micro\Library\DTO\ClassGeneratorFacadeDefault;
use Micro\Library\DTO\GeneratorFacadeInterface;
use Micro\Plugin\DTO\Business\FileLocator\FileLocatorFactoryInterface;
use Micro\Plugin\DTO\DTOPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use Psr\Log\NullLogger;

readonly class GeneratorFactory implements GeneratorFactoryInterface
{
    /**
     * @param FileLocatorFactoryInterface     $fileLocatorFactory
     * @param DTOPluginConfigurationInterface $DTOPluginConfiguration
     * @param LoggerFacadeInterface           $loggerFacade
     */
    public function __construct(
        private FileLocatorFactoryInterface $fileLocatorFactory,
        private DTOPluginConfigurationInterface $DTOPluginConfiguration,
        private LoggerFacadeInterface $loggerFacade
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): GeneratorInterface
    {
        return new Generator($this->createGeneratorFacade());
    }

    /**
     * @return GeneratorFacadeInterface
     */
    protected function createGeneratorFacade(): GeneratorFacadeInterface
    {
        $loggerName = $this->DTOPluginConfiguration->getLoggerName();
        $logger = new NullLogger();

        if ($loggerName) {
            $logger = $this->loggerFacade->getLogger($loggerName);
        }

        return new ClassGeneratorFacadeDefault(
            filesSchemeCollection: $this->fileLocatorFactory->create()->lookup(),
            outputPath: $this->DTOPluginConfiguration->getOutputPath(),
            namespaceGeneral: $this->DTOPluginConfiguration->getNamespaceGeneral(),
            classSuffix: $this->DTOPluginConfiguration->getClassSuffix(),
            logger: $logger,
        );
    }
}
