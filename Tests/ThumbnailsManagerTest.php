<?php namespace Modules\Tests;

use Modules\Media\Image\ThumbnailsManager;
use Modules\Media\Tests\MediaTestCase;

class ThumbnailsManagerTest extends MediaTestCase
{
    /**
     * @var \Modules\Media\Image\ThumbnailsManager
     */
    private $thumbnailManager;

    public function setUp()
    {
        parent::setUp();
        $this->thumbnailManager = new ThumbnailsManager(app('config'));
    }

    /** @test */
    public function it_is_true()
    {
        $this->assertTrue(true);
    }
}
