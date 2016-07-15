<?php

namespace Modules\Tests;

use Modules\Media\Image\ThumbnailManager;
use Modules\Media\Tests\MediaTestCase;

class ThumbnailsManagerTest extends MediaTestCase
{
    /**
     * @var ThumbnailManager
     */
    private $thumbnailManager;

    public function setUp()
    {
        parent::setUp();
        $this->thumbnailManager = app(ThumbnailManager::class);
    }

    /** @test */
    public function it_initialises_empty_array()
    {
        $this->assertEquals([], $this->thumbnailManager->all());
    }
}
