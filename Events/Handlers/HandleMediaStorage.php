<?php namespace Modules\Media\Events\Handlers;

use Modules\Media\Contracts\StoringMedia;
use Modules\Media\Image\Imagy;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Services\FileService;

class HandleMediaStorage
{
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var Imagy
     */
    private $imagy;

    public function __construct(FileRepository $file, Imagy $imagy)
    {
        $this->file = $file;
        $this->imagy = $imagy;
    }

    public function handle($event = null)
    {
        if ($event instanceof StoringMedia) {
            $this->handleMultiMedia($event);

            $this->handleSingleMedia($event);
        }
    }

    /**
     * Handle the request for the multi media partial
     * @param StoringMedia $event
     */
    private function handleMultiMedia(StoringMedia $event)
    {
        $entity = $event->getEntity();
        $postMedias = array_get($event->getSubmissionData(), 'medias_multi', []);

        foreach ($postMedias as $zone => $attributes) {
            $orders = $this->getOrdersFrom($attributes);
            foreach ($attributes['files'] as $fileId) {
                $order = array_search($fileId, $orders);
                $entity->files()->attach($fileId, ['imageable_type' => get_class($entity), 'zone' => $zone, 'order' => $order]);
            }
        }
    }

    /**
     * Handle the request to parse single media partials
     * @param StoringMedia $event
     */
    private function handleSingleMedia(StoringMedia $event)
    {
        $entity = $event->getEntity();
        $postMedia = array_get($event->getSubmissionData(), 'medias_single', []);

        foreach ($postMedia as $zone => $fileId) {
            $entity->files()->attach($fileId, ['imageable_type' => get_class($entity), 'zone' => $zone, 'order' => null]);
        }
    }

    /**
     * Parse the orders input and return an array of file ids, in order
     * @param array $attributes
     * @return array
     */
    private function getOrdersFrom(array $attributes)
    {
        $orderString = array_get($attributes, 'orders');

        if ($orderString === null) {
            return [];
        }

        $orders = explode(',', $orderString);

        return array_filter($orders);
    }
}
