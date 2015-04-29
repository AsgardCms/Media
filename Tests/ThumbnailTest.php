<?php namespace Modules\Tests;

use Modules\Media\Image\Thumbnail;

class ThumbnailTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_creates_thumbnail_class()
    {
        $thumbnail = Thumbnail::make($this->getBlogThumbnailConfig());

        $this->assertInstanceOf('Modules\Media\Image\Thumbnail', $thumbnail);
    }

    /** @test */
    public function it_gets_thumbnail_name()
    {
        $thumbnail = Thumbnail::make($this->getBlogThumbnailConfig());

        $this->assertEquals('blogThumb', $thumbnail->name());
    }

    /** @test */
    public function it_gets_thumbnail_filters()
    {
        $thumbnail = Thumbnail::make($this->getBlogThumbnailConfig());

        $expected = [
            'resize' => [
                'width' => 150,
                'height' => 150,
            ],
        ];
        $this->assertEquals($expected, $thumbnail->filters());
    }

    private function getThumbnailConfiguration()
    {
        return [
            $this->getBlogThumbnailConfig(),
            'smallThumb' => [
                'resize' => [
                    'width' => 50,
                    'height' => null,
                    'callback' => function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    },
                ],
            ],
            'mediumThumb' => [
                'resize' => [
                    'width' => 180,
                    'height' => null,
                    'callback' => function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    },
                ],
            ],
        ];
    }

    private function getBlogThumbnailConfig()
    {
        return [
            'blogThumb' => [
                'resize' => [
                    'width' => 150,
                    'height' => 150,
                ],
            ],
        ];
    }
}
