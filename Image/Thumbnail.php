<?php namespace Modules\Media\Image;

class Thumbnail
{
    /**
     * @var array
     */
    private $filters;
    /**
     * @var string
     */
    private $name;

    /**
     * @param $name
     * @param $filters
     */
    private function __construct($name, $filters)
    {
        $this->filters = $filters;
        $this->name = $name;
    }

    /**
     * @param $thumbnailDefinition
     * @return static
     */
    public static function make($thumbnailDefinition)
    {
        $name = key($thumbnailDefinition);

        return new static($name, $thumbnailDefinition[$name]);
    }

    /**
     * Return the thumbnail name
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function filters()
    {
        return $this->filters;
    }
}
