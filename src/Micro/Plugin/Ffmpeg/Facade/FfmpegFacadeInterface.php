<?php

namespace Micro\Plugin\Ffmpeg\Facade;

use FFMpeg\Exception\RuntimeException;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Media\Audio;
use FFMpeg\Media\Video;

interface FfmpegFacadeInterface
{
    /**
     * Open video or audio file
     *
     * @param string $filePath
     *
     * @return Video|Audio
     *
     * @throws RuntimeException
     */
    public function open(string $filePath): Video|Audio;

    /**
     * @return FFMpeg
     */
    public function ffmpeg(): FFMpeg;

    /**
     * @return FFProbe
     */
    public function ffprobe(): FFProbe;
}