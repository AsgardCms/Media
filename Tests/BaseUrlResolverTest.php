<?php namespace Modules\Media\Tests;

use Modules\Media\UrlResolvers\BaseUrlResolver;

class BaseUrlResolverTest extends MediaTestCase
{
    /** @test */
    public function it_returns_correct_local_uri()
    {
        config()->set('asgard.media.config.filesystem', 'local');

        $resolver = new BaseUrlResolver();
        $resolvedPath = $resolver->resolve('/assets/media/my_image.png');

        $this->assertEquals(config('app.url') . '/assets/media/my_image.png', $resolvedPath);
    }

    /** @test */
    public function it_returns_correct_aws_s3_uri()
    {
        config()->set('asgard.media.config.filesystem', 's3');
        config()->set('filesystems.disks.s3.bucket', 'testing-bucket');
        config()->set('filesystems.disks.s3.region', 'eu-west-1');

        $resolver = new BaseUrlResolver();
        $resolvedPath = $resolver->resolve('/assets/media/my_image.png');

        $this->assertEquals('https://s3-eu-west-1.amazonaws.com/testing-bucket/assets/media/my_image.png', $resolvedPath);
    }

    /** @test */
    public function it_returns_correct_aws_s3_uri_for_custom_s3_config()
    {
        $alternativeS3Config = 's3SomeAlternativeConfig';

        config()->set('asgard.media.config.filesystem', $alternativeS3Config);
        config()->set('filesystems.disks.' . $alternativeS3Config, config()->get('filesystems.disks.s3'));
        config()->set('filesystems.disks.' . $alternativeS3Config . '.bucket', 'testing-bucket');
        config()->set('filesystems.disks.' . $alternativeS3Config . '.region', 'eu-west-1');

        $resolver = new BaseUrlResolver();
        $resolvedPath = $resolver->resolve('/assets/media/my_image.png');

        $this->assertEquals('https://s3-eu-west-1.amazonaws.com/testing-bucket/assets/media/my_image.png', $resolvedPath);
    }
}
