# FFMPEG plugin

Wrapper for the [PHP-FFMpeg/PHP-FFMpeg](https://github.com/PHP-FFMpeg/PHP-FFMpeg) library.

## Installation

This library requires a working [FFMpeg install](https://ffmpeg.org/download.html). You will need both FFMpeg and FFProbe binaries to use it. Be sure that these binaries can be located with system PATH to get the benefit of the binary detection, otherwise you should have to explicitly give the binaries path on load.


Use the package manager [composer](https://getcomposer.org/) to install micro/plugin-ffmpeg.

```bash
composer require micro/plugin-ffmpeg
```

## Usage example

``` php
    $video = $container->get(FfmpegFacadeInterface::class)->open('video.mp4');
    $video
    ->filters()
        ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
        ->synchronize();
    $video
        ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
        ->save('frame.jpg');
    $video
        ->save(new FFMpeg\Format\Video\X264(), 'export-x264.mp4')
        ->save(new FFMpeg\Format\Video\WMV(), 'export-wmv.wmv')
        ->save(new FFMpeg\Format\Video\WebM(), 'export-webm.webm');
```

[More examples](https://github.com/PHP-FFMpeg/PHP-FFMpeg)

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)