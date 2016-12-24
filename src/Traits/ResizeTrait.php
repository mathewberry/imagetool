<?php

namespace Acuminata\Imagetool\Traits;

trait ResizeTrait
{
    protected static $virtual_image;

    public function resizeY($desired)
    {
        $width = imagesx(self::$original_image);
        $height = imagesy(self::$original_image);

        if($height > $desired) {
            $desired_height = $desired;
            $desired_width = floor($width * ($desired_height / $height));
            self::$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

            imagecopyresampled(self::$virtual_image, self::$original_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        } else {
            self::$virtual_image = imagecreatetruecolor($width, $height);
            imagecopyresampled(self::$virtual_image, self::$original_image, 0, 0, 0, 0, $width, $height, $width, $height);
        }

        return $this;
    }

    public function resizeX($desired)
    {
        $width = imagesx(self::$original_image);
        $height = imagesy(self::$original_image);

        if($width > $desired) {
            $desired_width = $desired;
            $desired_height = floor($height * ($desired_width / $width));
            self::$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

            imagecopyresampled(self::$virtual_image, self::$original_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        } else {
            self::$virtual_image = imagecreatetruecolor($width, $height);
            imagecopyresampled(self::$virtual_image, self::$original_image, 0, 0, 0, 0, $width, $height, $width, $height);
        }

        return $this;
    }
}