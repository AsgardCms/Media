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
                'height' => 250,
            ],
            'fit' => [
                'width' => 550,
                'height' => 650,
            ],
        ];
        $this->assertEquals($expected, $thumbnail->filters());
    }

    /** @test */
    public function it_gets_thumbnail_width()
    {
        $thumbnail = Thumbnail::make($this->getBlogThumbnailConfig());

        $this->assertSame(150, $thumbnail->width());
    }

    /** @test */
    public function it_gets_thumbnail_height()
    {
        $thumbnail = Thumbnail::make($this->getBlogThumbnailConfig());

        $this->assertSame(250, $thumbnail->height());
    }

    private function getBlogThumbnailConfig()
    {
        return [
            'blogThumb' => [
                'resize' => [
                    'width' => 150,
                    'height' => 250,
                ],
                'fit' => [
                    'width' => 550,
                    'height' => 650,
                ],
            ],
        ];
    }
}
