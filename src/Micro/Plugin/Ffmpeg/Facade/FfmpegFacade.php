<?php

namespace Micro\Plugin\Ffmpeg\Facade;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Media\Audio;
use FFMpeg\Media\Video;
use Micro\Plugin\Ffmpeg\Business\FfmpegFactory\FfmpegFactoryInterface;
use Micro\Plugin\Ffmpeg\Business\FfprobeFactory\FfprobeFactoryInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class FfmpegFacade implements FfmpegFacadeInterface
{
    /**
     * @param FfmpegFactoryInterface $ffmpegFactory
     * @param FfprobeFactoryInterface $ffprobeFactory
     */
    public function __construct(
        private FfmpegFactoryInterface $ffmpegFactory,
        private FfprobeFactoryInterface $ffprobeFactory
    ) {

    }

    /**
     * {@inheritDoc}
     */
    public function ffprobe(): FFProbe
    {
        return $this->ffprobeFactory->create();
    }

    /**
     * @return FFMpeg
     */
    public function ffmpeg(): FFMpeg
    {
        return $this->ffmpegFactory->create();
    }

    /**
     * {@inheritDoc}
     */
    public function open(string $filePath): Audio|Video
    {
        return $this->ffmpegFactory
            ->create()
            ->open($filePath);
    }
}