<?php

namespace Acuminata\Imagetool\Traits;

trait CropTrait
{
    public function crop($square_size)
    {
        $original_width = imagesx(self::$original_image);
        $original_height = imagesy(self::$original_image);

        if($original_width > $original_height){
            $new_height = $square_size;
            $new_width = $new_height * ($original_width/$original_height);
        }

        if($original_height > $original_width){
            $new_width = $square_size;
            $new_height = $new_width * ($original_height/$original_width);
        }

        if($original_height == $original_width){
            $new_width = $square_size;
            $new_height = $square_size;
        }

        $new_width = round($new_width);
        $new_height = round($new_height);
        $smaller_image = imagecreatetruecolor($new_width, $new_height);
        self::$virtual_image = imagecreatetruecolor($square_size, $square_size);

        imagecopyresampled($smaller_image, self::$original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width,
            $original_height);

        if($new_width > $new_height){
            $difference = $new_width - $new_height;
            $half_difference = round($difference / 2);

            imagecopyresampled(self::$virtual_image, $smaller_image, 0 - $half_difference + 1, 0, 0, 0,
                $square_size + $difference, $square_size, $new_width, $new_height);
        }

        if($new_height > $new_width) {
            $difference = $new_height - $new_width;
            $half_difference =  round($difference/2);

            imagecopyresampled(self::$virtual_image, $smaller_image, 0, 0 - $half_difference+1, 0, 0, $square_size,
                $square_size + $difference, $new_width, $new_height);
        }

        if($new_height == $new_width) {
            imagecopyresampled(self::$virtual_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size,
                $new_width, $new_height);
        }

        return $this;
    }

    public function coordinateCrop($src_x, $src_y, $src_wh, $dst_x, $dst_y, $dst_wh)
    {
        $sized = imagecreatetruecolor($dst_wh, $dst_wh);

        $width = imagesx(self::$virtual_image);
        $height = imagesy(self::$virtual_image);

        imagecopyresampled($sized, self::$virtual_image, 0, 0, 0, 0, $dst_wh, $dst_wh, $width, $height);

        imagecopyresampled(self::$virtual_image, $sized, $dst_x, $dst_y, $src_x, $src_y, $dst_wh, $dst_wh, $src_wh, $src_wh);
        return $this;
    }
}