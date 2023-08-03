<?php

namespace Micro\Plugin\Ffmpeg;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Ffmpeg\Configuration\FfmpegPluginConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class FfmpegPluginConfiguration extends PluginConfiguration implements FfmpegPluginConfigurationInterface
{
    public const CFG_FFMPEG_BINARIES = 'FFMPEG_BINARIES';
    public const CFG_FFPROBE_BINARIES = 'FFMPEG_FFPROBE_BINARIES';
    public const CFG_FFMPEG_PROCESS_TIMEOUT = 'FFMPEG_PROCESS_TIMEOUT';
    public const CFG_FFMPEG_THREADS_COUNT = 'FFMPEG_THREADS_COUNT';
    public const CFG_FFMPEG_TEMPORARY_DIRECTORY = 'FFMPEG_TEMPORARY_DIRECTORY';
    public const CFG_FFMPEG_LOGGER = 'FFMPEG_LOGGER';
    public const CFG_HW_ACCELERATION = 'FFMPEG_HW_ACCELERATION';

    /**
     * {@inheritDoc}
     */
    public function getFfmpegBinaryPath(): string
    {
        return $this->configuration->get(self::CFG_FFMPEG_BINARIES, '/usr/bin/ffmpeg');
    }

    /**
     * {@inheritDoc}
     */
    public function getFfprobeBinaryPath(): string
    {
        return $this->configuration->get(self::CFG_FFPROBE_BINARIES, '/usr/bin/ffprobe');
    }

    /**
     * {@inheritDoc}
     */
    public function getProcessTimeout(): int
    {
        return (int) $this->configuration->get(self::CFG_FFMPEG_PROCESS_TIMEOUT, 0);
    }

    /**
     * {@inheritDoc}
     */
    public function getTemporaryPath(): string
    {
        return $this->configuration->get(self::CFG_FFMPEG_TEMPORARY_DIRECTORY, '/var/cache/micro/ffmpeg');
    }

    /**
     * {@inheritDoc}
     */
    public function getThreadsCount(): int
    {
        return (int) $this->configuration->get(self::CFG_FFMPEG_THREADS_COUNT, 4);
    }

    /**
     * {@inheritDoc}
     */
    public function getLogger(): string|null
    {
        return $this->configuration->get(self::CFG_FFMPEG_LOGGER);
    }

    /**
     * {@inheritDoc}
     */
    public function getHwAccelerationMode(): string
    {
        return $this->configuration->get(self::CFG_HW_ACCELERATION, self::HW_ACCELERATION_MODE_DEFAULT);
    }
}