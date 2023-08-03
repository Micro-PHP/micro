<?php

namespace Micro\Plugin\Ffmpeg\Business\FfprobeFactory;

use FFMpeg\FFProbe;

interface FfprobeFactoryInterface
{
    public function create(): FFProbe;
}