<?php

namespace Micro\Plugin\Ffmpeg\Business\FfprobeFactory;

use FFMpeg\FFProbe;
use Micro\Plugin\Ffmpeg\Configuration\FfmpegPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class FfprobeFactory implements FfprobeFactoryInterface
{
    /**
     * @param LoggerFacadeInterface $loggerFacade
     * @param FfmpegPluginConfigurationInterface $pluginConfiguration
     */
    public function __construct(
        private LoggerFacadeInterface $loggerFacade,
        private FfmpegPluginConfigurationInterface $pluginConfiguration
    )
    {
    }

    public function create(): FFProbe
    {
        return FFProbe::create(
            [
                'ffprobe.binaries'  => $this->pluginConfiguration->getFfprobeBinaryPath(),
                'ffprobe.timeout'   => $this->pluginConfiguration->getProcessTimeout(),
            ],
            $this->loggerFacade->getLogger($this->pluginConfiguration->getLogger()),
        );
    }
}