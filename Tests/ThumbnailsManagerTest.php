<?php

namespace Modules\Tests;

use Modules\Media\Image\ThumbnailManagerRepository;
use Modules\Media\Tests\MediaTestCase;

class ThumbnailsManagerTest extends MediaTestCase
{
    /**
     * @var \Modules\Media\Image\ThumbnailManagerRepository
     */
    private $thumbnailManager;

    public function setUp()
    {
        parent::setUp();
        $this->thumbnailManager = new ThumbnailManagerRepository(app('config'));
    }

    /** @test */
    public function it_is_true()
    {
        $this->assertTrue(true);
    }
}
