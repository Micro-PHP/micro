<?php

namespace Micro\Plugin\Ffmpeg\Business\FfmpegFactory;

use FFMpeg\FFMpeg;

interface FfmpegFactoryInterface
{
    /**
     * @return FFMpeg
     */
    public function create(): FFMpeg;
}