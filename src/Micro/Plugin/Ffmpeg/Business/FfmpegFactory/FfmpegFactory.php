<?php

namespace Micro\Plugin\Ffmpeg\Business\FfmpegFactory;

use FFMpeg\FFMpeg;
use Micro\Plugin\Ffmpeg\Business\FfprobeFactory\FfprobeFactoryInterface;
use Micro\Plugin\Ffmpeg\Configuration\FfmpegPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class FfmpegFactory implements FfmpegFactoryInterface
{
    /**
     * @param FfmpegPluginConfigurationInterface $pluginConfiguration
     * @param FfprobeFactoryInterface $ffprobeFactory
     * @param LoggerFacadeInterface $loggerFacade
     */
    public function __construct(
        private readonly FfmpegPluginConfigurationInterface $pluginConfiguration,
        private readonly FfprobeFactoryInterface $ffprobeFactory,
        private readonly LoggerFacadeInterface $loggerFacade
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): FFMpeg
    {
        $loggerName = $this->pluginConfiguration->getLogger();
        $logger = $this->loggerFacade->getLogger($loggerName);

        $cfg = [
            'ffmpeg.binaries'   => $this->pluginConfiguration->getFfmpegBinaryPath(),
            'ffprobe.binaries'  => $this->pluginConfiguration->getFfprobeBinaryPath(),
            'timeout'           => $this->pluginConfiguration->getProcessTimeout(),
            'ffmpeg.threads'    => $this->pluginConfiguration->getThreadsCount(),
        ];

        $ffprobe = $this->ffprobeFactory->create();

        return FFMpeg::create($cfg, $logger, $ffprobe);
    }
}