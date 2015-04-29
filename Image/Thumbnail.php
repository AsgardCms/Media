<?php namespace Modules\Media\Image;

class Thumbnail
{
    private $filters;
    private $name;

    private function __construct($name, $filters)
    {
        $this->filters = $filters;
        $this->name = $name;
    }

}
