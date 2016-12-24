<?php

namespace Acuminata\Imagetool;

use Acuminata\Imagetool\Traits\CropTrait;
use Acuminata\Imagetool\Traits\ResizeTrait;
use Acuminata\Imagetool\Traits\SaveTrait;
use Illuminate\Http\Request;

class Image {

    use CropTrait, ResizeTrait, SaveTrait;

    /**
     * The cloned version of the original image.
     *
     * @var
     */
    protected static $virtual_image;

    /**
     * The original images contents from upload.
     *
     * @var
     */
    protected static $original_image;

    /**
     * The quality of the image.
     *
     * @var
     */
    protected static $quality = 9;

    /**
     * Used to set the compression level.
     *
     * @var
     */
    protected static $compression_level = 100;

    public static function new($file)
    {
        $content = $file;

        try {
            $image = imagecreatefromstring($content);
            imagedestroy($image);
            unset($image);
        } catch(\ErrorException $exception) {
            if($file instanceof Request) {
                $content = file_get_contents($file);
            }

            if(file_exists($file)) {
                $content = file_get_contents($file);
            }
        }

        if($content == $file) {
            throw new \Exception('[ImageTool] Invalid image');
        }

        self::$original_image = imagecreatefromstring($content);

        return new static;
    }

    public function clone()
    {
        self::$virtual_image = self::$original_image;

        return $this;
    }

    public function watermark($image, $top, $right, $bottom, $left)
    {
        return $this;
    }

    public function transparency()
    {
        return $this;
    }

    public function quality($quality)
    {
        if(is_int($quality)) {
            if((0 <= $quality) && ($quality <= 9)) {
                self::$quality = $quality;
            }
        } else {
            throw new \Exception('[ImageTool] Invalid quality');
        }

        return $this;
    }

    public function compress($level)
    {
        self::$compression_level = $level;

        return $this;
    }

    public function stream()
    {
        header('Content-Type: image/png');

        if(!empty(self::$virtual_image)) {
            imagejpeg(self::$virtual_image, null, self::$compression_level);
            imagedestroy(self::$virtual_image);
        } else {
            imagejpeg(self::$original_image);
            imagedestroy(self::$original_image);
        }
    }
}