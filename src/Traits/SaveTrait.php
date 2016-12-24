<?php

namespace Acuminata\Imagetool\Traits;

trait SaveTrait
{
    protected static $virtual_image;

    public function save($path = null, $name = null)
    {

    }

    public function saveByDate($path, $name)
    {

    }

    public function storage($disk)
    {
        return $this;
    }
}