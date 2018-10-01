<?php

namespace App\Classes;

use Intervention\Image\Facades\Image as InterventionImage;

class Image
{
    /**
     * Combine an array of images into one.
     *
     * @param array $images
     * @param $destination
     * @param int    $padding
     * @param string $orientation
     *
     * @return string
     */
    public static function combine(array $images, $destination, $padding = -20, $orientation = 'vertical')
    {
        $width = 1200;
        $height = 1200;

        $position = 'vertical' === $orientation ? 'bottom-center' : 'top-right';

        /** @var \Intervention\Image\Image $canvas */
        $canvas = InterventionImage::canvas($width, $height);

        foreach ($images as $key => $file) {
            $img = InterventionImage::make($file);

            $maxWidth = $img->width() > $canvas->width() ? $img->width() : $canvas->width();

            $width = $key ? $maxWidth : $img->width();
            $height = $key ? $canvas->height() + $img->height() + 20 : $img->height();

            $canvas->resizeCanvas($width, $height, 'top'/*, false, '#ff00ff'*/);

            $canvas->insert($img, $key ? $position : 'top-center', $padding);
        }

        $canvas->save($destination);

        return $canvas->basePath();
    }
}
