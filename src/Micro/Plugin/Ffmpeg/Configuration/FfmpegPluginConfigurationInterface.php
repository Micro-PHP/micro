<?php

namespace Micro\Plugin\Ffmpeg\Configuration;

interface FfmpegPluginConfigurationInterface
{
    const HW_ACCELERATION_MODE_DEFAULT = 'auto';

    /**
     * @return int
     */
    public function getThreadsCount(): int;

    /**
     * @return string
     */
    public function getFfmpegBinaryPath(): string;

    /**
     * @return string
     */
    public function getFfprobeBinaryPath(): string;

    /**
     * @return int
     */
    public function getProcessTimeout(): int;

    /**
     * @return string
     */
    public function getTemporaryPath(): string;

    /**
     * @return string|null
     */
    public function getLogger(): string|null;

    /**
     * @return string
     */
    public function getHwAccelerationMode(): string;
}